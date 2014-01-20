<?php
// default informations	
$thedb = $graphdb;
$gexf=$_GET["gexf"];
// just for papers detail for ademe

$temp=explode('/',$graphdb);
$corpora=$temp[count($temp)-2];
//echo $mainpath.'data/'.$corpora.'/'.$corpora.'.sqlite';
$corporadb = new PDO("sqlite:" .$mainpath.'data/'.$corpora.'/'.$corpora.'.sqlite'); //data base with complementary data


$output = "<ul>"; // string sent to the javascript for display

#http://localhost/branch_ademe/php/test.php?type=social&query=[%22marwah,%20m%22]


$type = $_GET["type"];
$query = str_replace( '__and__', '&', $_GET["query"] );
$elems = json_decode($query);
// nombre d'item dans les tables 
$sql='SELECT COUNT(*) FROM ISIABSTRACT';
foreach ($base->query($sql) as $row) {
	$table_size=$row['COUNT(*)'];
}


///// Specific to rock //////////
// Other restrictions
// extracting the project folder and the year
$temp=explode('/',$thedb);
$project_folder=$temp[1];	


$table = "";
$column = "";
$id="";
$twjs="tinawebJS/"; // submod path of TinaWebJS

if($type=="social"){
	$table = "ISIAUTHOR";
	$column = "data";
	$id = "id";
	$restriction='';
	$factor=10;// factor for normalisation of stars
}

if($type=="semantic"){
	$table = "ISIterms";
	$column = "data";
	$id = "id";
	$restriction='';
	$factor=10;
}

// identification d'une année pour echoing
if($project_folder=='nci'){
	$restriction.="";
}

$sql = 'SELECT count(*),'.$id.'
FROM '.$table.' where (';
        foreach($elems as $elem){
                $sql.=' '.$column.'="'.$elem.'" OR ';
        }
#$querynotparsed=$sql;#####
        $sql = substr($sql, 0, -3);
        $sql = str_replace( ' & ', '" OR '.$column.'="', $sql );

        $sql.=')'.$restriction.'
GROUP BY '.$id.'
ORDER BY count('.$id.') DESC
LIMIT 1000';


#$queryparsed=$sql;#####

$wos_ids = array();
$sum=0;

//The final query!
// array of all relevant documents with score

foreach ($base->query($sql) as $row) {        
        // on pondère le score par le nombre de termes mentionnés par l'article
        
        //$num_rows = $result->numRows();
        $wos_ids[$row[$id]] = $row["count(*)"];
        $sum = $row["count(*)"] +$sum;
}

$number_doc=ceil(count($wos_ids)/3);
$count=0;
foreach ($wos_ids as $id => $score) {	
	if ($count<$max_item_displayed){
		// retrieve publication year
		$sql = 'SELECT data FROM ISIpubdate WHERE id='.$id;
		foreach ($base->query($sql) as $row) {
			$pubdate=$row['data'];
		}

		// to filter under some conditions
		$to_display=true; 
	

		if ($to_display){
			$count+=1;
			$output.="<li title='".$score."'>";
			$output.=imagestar($score,$factor,$twjs).' ';	
			$sql = 'SELECT data FROM ISITITLE WHERE id='.$id;

			foreach ($base->query($sql) as $row) {
				$output.='<a href="JavaScript:newPopup(\''.$twjs.'php/default_doc_details.php?db='.urlencode($thedb).'&gexf='.urlencode($gexf).'&query='.urlencode($query).'&type='.urlencode($_GET["type"]).'&id='.$id.'	\')">'.$row['data']." </a> ";
				$external_link="<a href=http://scholar.google.com/scholar?q=".urlencode('"'.$row['data'].'"')." target=blank>".' <img width=8% src="'.$twjs.'img/gs.png"></a>';	
			}

	// get the authors
			$sql = 'SELECT data FROM ISIAUTHOR WHERE id='.$id;
			foreach ($base->query($sql) as $row) {
				$output.=strtoupper($row['data']).', ';
			}

			if($project_folder!='nci'){
				
				$output.='('.$pubdate.') ';

			}else {
				$output.='(2013) ';
			}
	
			$output.=$external_link."</li><br>";			
		}

	}else{
		continue;
	}
}

$output .= "</ul>"; #####

// for NCI we compare the impact and novelty score making the difference
$news='';//new terms
if ($project_folder=='nci'){
	$diff=array();
	foreach ($elems as $key => $term) {
		$sql=	"select  count(*),ISIterms.id, ISIterms.data from ISIterms join ISIpubdate on (ISIterms.id=ISIpubdate.id AND ISIpubdate.data=2011 AND ISIterms.data='".$term."') group by ISIterms.data";
	
		foreach ($base->query($sql) as $row) {
			$nov=$row['count(*)'];
		}
		$sql=	"select  count(*),ISIterms.id, ISIterms.data from ISIterms join ISIpubdate on (ISIterms.id=ISIpubdate.id AND ISIpubdate.data=2012 AND ISIterms.data='".$term."') group by ISIterms.data";
		foreach ($base->query($sql) as  $row) {
			$imp=$row['count(*)'];
		}
		$diff[$term]=($nov-$imp);
		
	}	
	arsort($diff);
	$res=array_keys($diff);
	$news.='<br/><b><font color="#FF0066">Top 3 Novelty related terms </font></b>'.$res[0].', '.$res[1].', '.$res[2].'<br/>';
	asort($diff);	
	$res=array_keys($diff);	
	$news.='<br/><b><font color="#CF5300">Top 3 Impact related terms: </font></b>'.$res[0].', '.$res[1].', '.$res[2].'<br/>';	
}


function imagestar($score,$factor,$twjs) {
// produit le html des images de score
	$star_image = '';
	if ($score > .5) {
		$star_image = '';
		for ($s = 0; $s < min(5,$score/$factor); $s++) {
			$star_image.='<img src="'.$twjs.'img/star.gif" border="0" >';
		}
	} else {
		$star_image.='<img src="'.$twjs.'img/stargrey.gif" border="0">';
	}
	return $star_image;
}

echo $news.'<br/><b><font color="#0000FF"> Top '.$count.' projects:</font></b>'.$output;
//pt - 301 ; 15.30
?>
