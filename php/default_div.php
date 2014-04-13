<?php
// default informations	
$thedb = $graphdb;
$gexf=$_GET["gexf"];
// just for papers detail for ademe

$temp=explode('/',$graphdb);
$corpora=$temp[count($temp)-2];
//echo $mainpath.'data/'.$corpora.'/'.$corpora.'.sqlite';
$corporadb = new PDO("sqlite:" .$mainpath.'data/'.$corpora.'/'.$corpora.'.sqlite'); //data base with complementary data
$corporadb_name='data/'.$corpora.'/'.$corpora.'.sqlite'; // chemin vers la base de données complémentaire

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
	$top_displayed=5;// nombre de novelty and impact displayed
	$nov_impact_max_freq=30; //nb mas d'occurrences pour qu'un terme soit considérer dans la liste des impacts ou novelties
	$max_selection_size=20; // taille max de la selection pour faire apparaitre les impacts ou novelty
	
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
	$restriction.="";
}		

//////////
if (count($elems)==1){// un seul mot est sélectionné, on compte les mots multiples
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
}else{// on compte une seule fois un mot dans un article
	$factor=ceil(count($elems)/5); //les scores sont moins haut
	$sqlquery='';
	foreach($elems as $elem){
          	$sqlquery.=' '.$column.'="'.$elem.'" OR ';
        }
    $sqlquery=substr($sqlquery, 0, -3);
    $sql='SELECT count(*),id,data FROM (SELECT *
	FROM '.$table.' where ('.$sqlquery.')'.$restriction.'
	 group by id,data) GROUP BY '.$id.'
	ORDER BY count('.$id.') DESC
	LIMIT 1000';

}


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

// /// nombre de document associés $related
$total_count=0;
$count_max=500;	

foreach ($wos_ids as $id => $score) {	
		if ($total_count<=$count_max){
		$sql = 'SELECT data FROM ISIpubdate WHERE id='.$id;
		foreach ($base->query($sql) as $row) {
			$pubdate=$row['data'];
		}

		// to filter under some conditions
		if ($project_folder=='echoing'){
			if ($year_filter){
				if ($pubdate==$year){
					$total_count+=1;
				}
			}			
		}elseif($project_folder=='nci'){
			if ($year_filter){
				if ($pubdate=='2013'){
					$total_count+=1;
				}
			}	
		}

		}
}

if ($total_count<$count_max){
	$related .= $total_count;
}else{
	$related .= ">".$count_max;
}
////////////

$all_terms_from_selected_projects=array();// list of terms for the top 6 project selected

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
				$output.='<a href="JavaScript:newPopup(\''.$twjs.'php/default_doc_details.php?db='.urlencode($graphdb).'&gexf='.urlencode($gexf).'&query='.urlencode($query).'&type='.urlencode($_GET["type"]).'&id='.$id.'	\')">'.$row['data']." </a> ";
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

			//SELECT ISIterms.data,termsFreq.freq FROM ISIterms,termsFreq WHERE ISIterms.id=3104 AND ISIterms.data=termsFreq.data   AND termsFreq.freq<48
			$sql = 'SELECT ISIterms.data,termsFreq.freq FROM ISIterms,termsFreq WHERE ISIterms.id='.$id. ' AND ISIterms.data=termsFreq.data AND termsFreq.freq<'.$nov_impact_max_freq;
			foreach ($base->query($sql) as $row) {
				$all_terms_from_selected_projects[]=$row['data'];
			}		
		}

	}else{
		continue;
	}
}

$output .= "</ul>"; #####


if (($project_folder=='nci')&&(count($elems)<$max_selection_size)){
	// for NCI we compare the impact and novelty score making the difference if there are more than 4 terms selected
	$news='';//new terms
	$terms_from_selected_projects=array_unique($all_terms_from_selected_projects); 
	if(count($terms_from_selected_projects)>3){
	$diff=array();
	foreach ($terms_from_selected_projects as $key => $term) {
		$sql=	"select  count(*),ISIterms.id, ISIterms.data from ISIterms join ISIpubdate on (ISIterms.id=ISIpubdate.id AND ISIpubdate.data=2011 AND ISIterms.data='".$term."') group by ISIterms.data";
		$nov=0;
		foreach ($corporadb->query($sql) as $row) {
			$nov=$row['count(*)'];
		}
		$sql=	"select  count(*),ISIterms.id, ISIterms.data from ISIterms join ISIpubdate on (ISIterms.id=ISIpubdate.id AND ISIpubdate.data=2012 AND ISIterms.data='".$term."') group by ISIterms.data";
		$imp=0;
		foreach ($corporadb->query($sql) as  $row) {
			$imp=$row['count(*)'];
		}
		$diff[$term]=info($nov,$imp); //positive si c'est un term novelty, negatif si c'est un terme impact.
		//echo $term.'-nov: '.$nov.'- imp:'.$imp.'<br/>';//'-info'.$diff[$term].
	}	

if (true){
	arsort($diff);
	$res=array_keys($diff);
	//echo implode(', ', $res);
	$nov_string='';
	for ($i=0;$i<$top_displayed;$i++){

		// on récupère les titres du document qui a le plus for impact
		$sql="SELECT ISIterms.id,ISIC1_1.data,count(*) from ISIterms,ISIpubdate,ISIC1_1 where ISIterms.data='".$res[$i]."' AND  ISIterms.id=ISIpubdate.id AND ISIterms.id=ISIC1_1.id AND ISIpubdate.data='2011' group by ISIterms.id ORDER BY RANDOM()  limit 1";	

		//on récupère les id associés.
		foreach ($corporadb->query($sql) as $row){
			$sql2='SELECT ISIpubdate.id,ISIC1_1.data from ISIpubdate,ISIC1_1 where ISIC1_1.data="'.$row['data'].'" AND  ISIpubdate.id=ISIC1_1.id AND ISIpubdate.data="2013"  limit 1';
			//echo $sql2;
			foreach ($corporadb->query($sql2) as $row2){
				$nov_string.='<a href="JavaScript:newPopup(\''.$twjs.'php/default_doc_details.php?db='.urlencode($graphdb).'&gexf='.urlencode($gexf).'&query='.urlencode('["'.$res[$i].'"]').'&type='.urlencode($_GET["type"]).'&id='.$row2['id'].'	\')">'.$res[$i]."</a>, ";	
			}		
		}
	}

	$news.='<br/><b><font color="#FF0066">Top '.$top_displayed.' Novelty related terms </font></b>'.$nov_string.'<br/>';
	asort($diff);	
	$res=array_keys($diff);	
	$res_string='';
	for ($i=0;$i<$top_displayed;$i++){

		// on récupère les titres du document qui a le plus for impact
		$sql="SELECT ISIterms.id,ISIC1_1.data,count(*) from ISIterms,ISIpubdate,ISIC1_1 where ISIterms.data='".$res[$i]."' AND  ISIterms.id=ISIpubdate.id AND ISIterms.id=ISIC1_1.id AND ISIpubdate.data='2012' group by ISIterms.id ORDER BY RANDOM()limit 1";	

		//on récupère les id associés.
		foreach ($corporadb->query($sql) as $row){
			$sql2='SELECT ISIpubdate.id,ISIC1_1.data from ISIpubdate,ISIC1_1 where ISIC1_1.data="'.$row['data'].'" AND  ISIpubdate.id=ISIC1_1.id AND ISIpubdate.data="2013"  limit 1';
			//echo $sql2;
			foreach ($corporadb->query($sql2) as $row2){
				$res_string.='<a href="JavaScript:newPopup(\''.$twjs.'php/default_doc_details.php?db='.urlencode($graphdb).'&gexf='.urlencode($gexf).'&query='.urlencode('["'.$res[$i].'"]').'&type='.urlencode($_GET["type"]).'&id='.$row2['id'].'	\')">'.$res[$i]."</a>, ";	
			}		
		}
	}
	$news.='<br/><b><font color="#CF5300">Top '.$top_displayed.' Impact related terms: </font></b>'.$res_string.'<br/>';	
}
}	
}
// display the most occuring terms when only one is selected.
//elseif (count($elems)==1) {// on affiche les voisins
//	$terms_array=array();
//	$id_sql='SELECT ISIterms.id FROM ISIterms where ISIterms.data="'.$elems[0].'" group by id';
//	foreach ($base->query($id_sql) as $row_id) {			
//			$sql2='SELECT ISIterms.data FROM ISIterms where ISIterms.id='.$row_id['id'];
//			foreach ($base->query($sql2) as $row_terms) {				
//				if ($terms_array[$row_terms['data']]>0){
//					$terms_array[$row_terms['data']]=$terms_array[$row_terms['data']]+1;	
//				}else{
//					$terms_array[$row_terms['data']]=1;		
//				}				
//			}			
//		}
//		natsort($terms_array);			
//		$terms_list=array_keys(array_slice($terms_array,-11,-1));
//		foreach ($terms_list as $first_term) {
//			$related_terms.=$first_term.', ';
//		}															
//	$news.='<br/><b><font color="#CF5300">Related terms: </font></b>'.$related_terms.'<br/>';
//}

   // calculate binomial coefficient
 function binomial_coeff($n, $k) {

      $j = $res = 1;

      if($k < 0 || $k > $n)
         return 0;
      if(($n - $k) < $k)
         $k = $n - $k;

      while($j <= $k) {
         $res *= $n--;
         $res /= $j++;
      }

      return $res;

   }

 function info($novelty, $impact) {// pour un terme donné, calcule l'information associée à l'observation de $novelty occurrences $impact occurrences
 if ($novelty==$impact){
 	return 0;
 }else{
 	$info=($novelty/($novelty+$impact)-0.5)*min(log(1+($novelty+$impact)/2),1.5);
 	//echo $info.'<br/>';
	 return $info;//positive si c'est un term novelty, negatif si c'est un terme impact.
}
 
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

echo $news.'<br/><b><font color="#0000FF"> Top '.$count.'/'.$related.' related projets:</font></b>'.$output;
//pt - 301 ; 15.30
?>
