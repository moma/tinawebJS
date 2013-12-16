<?php

$db= $_GET["db"];//I receive the specific database as string!
$query=$_GET["query"];
$gexf=$_GET["gexf"];

include('parameters_details.php');
$base = new PDO("sqlite:" .$mainpath.$db);

echo '
<html>
<head>
<meta charset="utf-8" />
<title>Document details</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

</head>

<body>';

echo '<div>';

$type = $_GET["type"];
$query = str_replace( '__and__', '&', $_GET["query"] );
$elems = json_decode($query);
$table = "";
$column = "";
$id="";
$twjs="tinawebJS/"; // submod path of TinaWebJS


// nombre d'item dans les tables 
$sql='SELECT COUNT(*) FROM ISIABSTRACT';
foreach ($base->query($sql) as $row) {
  $table_size=$row['COUNT(*)'];
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
if($type=="social"){
  $table = "ISIAUTHOR";
  $column = "data";
  $id = "id";
  $restriction='';
  $factor=3;// factor for normalisation of stars
}

if($type=="semantic"){
  $table = "ISIterms";
  $column = "data";
  $id = "id";
  $restriction='';
  $factor=10;
}

$sql = 'SELECT count(*),'.$id.'
FROM '.$table.' where (';

// list of keywords
  $keywords='';

  foreach($elems as $elem){
    $sql.=' '.$column.'="'.$elem.'" OR ';
    $keywords.=$elem.' OR ';
  }
  $keywords=substr($keywords,0,-4);
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
      //echo $row2['count(*)'].'-'.$table_size.'-'.$elems_freq[$value].'<br/>';
      $tfidf+=log(1+$row2['count(*)'])  *log($table_size/$elems_freq[$value]);
    }
  }
  
  //$num_rows = $result->numRows();
  $wos_ids[$row[$id]] = $tfidf;//$row["count(*)"];
  $sum = $row["count(*)"] +$sum;
}

///// Specific to rock //////////
// Other restrictions
// extracting the project folder and the year
$temp=explode('/',$db);
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
  $year='2013';
}

$number_doc=count($wos_ids);

arsort($wos_ids);
$output .= $number_doc.' items related to: '.$keywords.'<br/><br/>';
$count=0;
foreach ($wos_ids as $id => $score) {
  if ($count<1000){
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
        $output.='<a href="default_doc_details.php?db='.urlencode($db).'&type='.urlencode($_GET["type"]).'&query='.urlencode($query).'&id='.$id.'">'.$row['data']." </a> ";


                        //this should be the command:
      //$output.='<a href="JavaScript:newPopup(\''.$twjs.'php/default_doc_details.php?db='.urlencode($datadb).'&id='.$id.'  \')">'.$row['data']." </a> "; 

                        //the old one:  
      //$output.='<a href="JavaScript:newPopup(\''.$twjs.'php/default_doc_details.php?id='.$id.'  \')">'.$row['data']." </a> ";   
        $external_link="<a href=http://scholar.google.com/scholar?q=".urlencode('"'.$row['data'].'"')." target=blank>".' <img width=20px src="img/gs.png"></a>'; 
    //$output.='<a href="JavaScript:newPopup(''php/doc_details.php?id='.$id.''')"> Link</a>'; 
      }

  // get the authors
      $sql = 'SELECT data FROM ISIAUTHOR WHERE id='.$id;
      foreach ($base->query($sql) as $row) {
        $output.=strtoupper($row['data']).', ';
      }




  //<a href="JavaScript:newPopup('http://www.quackit.com/html/html_help.cfm');">Open a popup window</a>'
      $output.='('.$pubdate.') '.$external_link."</li><br>";
    }
  }else{
    continue;
  }
}
$output .= "</ul>"; #####
$output .= "<br><br><center><a href='#'><img width='50px' onclick='selectionToMap();' title='See the world distribution!' src='".$twjs."img/world.png'></img></a></center>";


function imagestar($score,$factor,$twjs) {
// produit le html des images de score
  $star_image = '';
  if ($score > .5) {
    $star_image = '';
    for ($s = 0; $s < min(5,$score/$factor); $s++) {
      $star_image.='<img src="img/star.gif" border="0" >';
    }
  } else {
    $star_image.='<img src="img/stargrey.gif" border="0">';
  }
  return $star_image;
}

echo $output;
//pt - 301 ; 15.30
?>


?>
