<?php
// default informations	
$thedb = $graphdb;
$gexf=$_GET["gexf"];
// just for papers detail for ademe
$isAdeme=$_SERVER["PHP_SELF"];
//if (strpos($isAdeme, 'ademe') !== false) $thedb = $datadb;

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
//echo $gexf;
if (strpos($gexf,'2013')>0){
	$year='2013';	
	$year_filter=true;
}elseif (strpos($gexf,'2012')>0){
	$year='2012';
	$year_filter=true;
}else{
	$year_filter=false;
}

// identification d'une année pour echoing
if($project_folder=='nci'){
	$year_filter=true;	
	
}

// process of terms frequency in corpora for tidf
$elems_freq=array();
foreach ($elems as $key => $value) {
	// we count the number of occ in the doc
	$sql="SELECT count(*) FROM ISITerms Where data='".$value."' group by id";
	$result = $base->query($sql);
	foreach ($result as $row) {
		$nb_doc = $row['count(*)'];	
	}	
	$elems_freq[$value]=$nb_doc;		
	}

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
	$restriction.=" AND ISIpubdate='2013'";
}

$sql = 'SELECT count(*),'.$id.'
FROM '.$table.' where (';
	foreach($elems as $elem){
		$sql.=' '.$column.'="'.$elem.'" OR ';
	}
#$querynotparsed=$sql;#####
	$sql = substr($sql, 0, -3);
	$sql = str_replace( ' & ', '" OR '.$column.'="', $sql );

	$sql.=')
GROUP BY '.$id.'
ORDER BY count('.$id.') DESC
LIMIT 1000';

//echo $sql.'<br/>';
#$queryparsed=$sql;#####

$wos_ids = array();
$sum=0;

//echo $sql;//The final query!
// array of all relevant documents with score
foreach ($base->query($sql) as $row) {	
	// on calcul le tfidf par document
	// identifiant de l'article
	$tfidf=0;
	$doc_id=$row['id']; 
	//echo $doc_id.' Doc ID<br/>';
	//print_r($elems);
	// pour tous les terms du document qui sont dans la query
	foreach ($elems as $key => $value) {
		// we count the number of occ in the doc
		$sql2="SELECT count(*) from ISIterms where (id=".$doc_id." and data='".$value."') group by id";
		//echo $sql2.'<br/>';
		foreach ($base->query($sql2) as $row2) {			
			//	echo $row2['count(*)'].'-'.$table_size.'-'.$elems_freq[$value].'<br/>';;
			$tfidf+=log(1+$row2['count(*)'])*log($table_size/$elems_freq[$value]);
		}
	}
	//$num_rows = $result->numRows();
	$wos_ids[$row[$id]] = $tfidf;//$row["count(*)"];
	$sum = $row["count(*)"] +$sum;
}



arsort($wos_ids);
$number_doc=count($wos_ids);
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
		if ($project_folder=='echoing'){
			if ($year_filter){
				if ($pubdate!=$year){
					$to_display=false;
				}
			}			
		}elseif($project_folder=='nci'){
			if ($year_filter){
				if ($pubdate!='2013'){
					$to_display=false;
				}
			}	
		}

		if ($to_display){

			$count+=1;
			$output.="<li title='".$score."'>";
			$output.=imagestar($score,$factor,$twjs).' ';	
			$sql = 'SELECT data FROM ISITITLE WHERE id='.$id;

			foreach ($base->query($sql) as $row) {
				$output.='<a href="JavaScript:newPopup(\''.$twjs.'php/default_doc_details.php?db='.urlencode($thedb).'&query='.urlencode($query).'&type='.urlencode($_GET["type"]).'&id='.$id.'	\')">'.$row['data']." </a> ";

                        //this should be the command:
			//$output.='<a href="JavaScript:newPopup(\''.$twjs.'php/default_doc_details.php?db='.urlencode($datadb).'&id='.$id.'	\')">'.$row['data']." </a> ";	

                        //the old one:	
			//$output.='<a href="JavaScript:newPopup(\''.$twjs.'php/default_doc_details.php?id='.$id.'	\')">'.$row['data']." </a> ";		
				$external_link="<a href=http://scholar.google.com/scholar?q=".urlencode('"'.$row['data'].'"')." target=blank>".' <img width=8% src="'.$twjs.'img/gs.png"></a>';	
		//$output.='<a href="JavaScript:newPopup(''php/doc_details.php?id='.$id.''')"> Link</a>';	
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



	//<a href="JavaScript:newPopup('http://www.quackit.com/html/html_help.cfm');">Open a popup window</a>'

			$output.=$external_link."</li><br>";			
		}

	}else{
		continue;
	}
}
$output .= "</ul>[".$max_item_displayed." top items over ".$number_doc.']'; #####


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

echo $output;
//pt - 301 ; 15.30
?>
