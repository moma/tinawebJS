<?php

$db= $_GET["db"];//I receive the specific database as string!
$terms_of_query=json_decode($_GET["query"]);

include('parameters_details.php');
include('../../geomap/php/countries_iso3166.php');
$base = new PDO("sqlite:" .$mainpath.$db);


echo '
<html>
        <head>
  <meta charset="utf-8" />
  <title>Document details</title>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  
  <script>
  $(function() {
    $( "#tabs" ).tabs({
      collapsible: true
    });
  });
  </script>
</head>
          
    <body>
    <div id="tabs">
  <ul>
    <li><a href="#tabs-1">Selected Document</a></li>
    <li><a href="full_doc_list.php?'.'db='.urlencode($_GET["db"]).'&type='.urlencode($_GET["type"]).'&query='.urlencode($_GET["query"]).'">Full list</a></li>';    
  echo '</ul>';

echo '<div id="tabs-1">';

$id=$_GET["id"];
//$elems = json_decode($query);
	$sql = 'SELECT data FROM ISITITLE WHERE id='.$id;
	foreach ($base->query($sql) as $row) {
		$output.='<h2>'.$row['data'].'</h2>';
		$find.="<br/><a href=http://scholar.google.com/scholar?q=".urlencode('"'.$row['data'].'"')." target='blank'>[ Search on the web ] </a>";		
	}
  // get the authors
  $sql = 'SELECT data FROM ISIAUTHOR WHERE id='.$id;
  foreach ($base->query($sql) as $row) {
    $output.=strtoupper($row['data']).' ';
  }



  // get the date
  $sql = 'SELECT data FROM ISIpubdate WHERE id='.$id;
  foreach ($base->query($sql) as $row) {
    $output.='('.$row['data'].') ';
  }

// get the country
  $sql = 'SELECT data FROM ISIkeyword WHERE id='.$id;
  foreach ($base->query($sql) as $row) {
    $country=$CC[strtoupper($row['data'])];
  
    $output.=strtoupper($country).'<br/>   ';
  }

  // get the date
  $sql = 'SELECT data FROM ISIterms WHERE id='.$id;
  $output.='<br/><b>Keywords: </b>';
  $terms=array();
  foreach ($base->query($sql) as $row) {
    $terms[]=$row['data'];
  }
  natsort($terms);
  $terms=array_unique($terms); // liste des termes de l'article
  $keywords='';
  foreach ($terms as $key => $value) {
    $keywords.=$value.', ';
  }

  foreach ($terms_of_query as $key => $value) {
      $keywords=str_replace($value,'<font color="green"><b> '.$value.'</b></font>',$keywords);
    }
    foreach (array_diff($terms,$terms_of_query) as $key => $value) {
      $keywords=str_ireplace($value,'<font color="#800000"> '.$value.'</font>',$keywords);
    }

  $output.='<p align="justify">'.$keywords.'</p>';


  // get the website
  $sql = 'SELECT data FROM ISISO WHERE id='.$id;
  foreach ($base->query($sql) as $row) {
    $www=$row['data'];
    str_replace('http://', '', $www);

    $output.='<b>Website: </b><a href="http://'.$www.'" target=blank>'.$row['data'].'</a> '.'<br/> ';
  }

	$sql = 'SELECT data FROM ISIABSTRACT WHERE id='.$id;
	foreach ($base->query($sql) as $row) {
    $abs=$row['data'];

    $abs=str_replace('ISSUES:'  ,'<br/><br/><b>Issues:</b>',$abs);
    $abs=str_replace('INTENDED IMPACT:'  ,'<br/><br/><b>Intended impact:</b>',$abs);    
    $abs=str_replace('IMPACT:'  ,'<br/><br/><b>Impact:</b>',$abs);
    $abs=str_replace('NOVELTY:'  ,'<br/><br/><b>Novelty:</b>',$abs);
    $abs=str_replace('BOLD INNOVATION:'  ,'<br/><br/><b>Bold innovation:</b>',$abs);
    $abs=str_replace('SOCIAL PROBLEM:'  ,'<br/><br/><b>Social problem:</b>',$abs);

    // solving encoding pb
    $abs=str_replace('â€•', ' ', $abs);
    $abs=str_replace('â€Ÿâ€Ÿ', ' ', $abs);
    $abs=str_replace('â€žâ€Ÿ', ' ', $abs);
    $abs=str_replace('_x000D_', ' ', $abs);
    $abs=str_replace('â€¢', ' ', $abs);
    $abs=str_replace('â€™', '\'', $abs);

    foreach ($terms_of_query as $key => $value) {
      $abs=str_ireplace($value,'<font color="green"><b> '.$value.'</b></font>',$abs);
    }
    foreach (array_diff($terms,$terms_of_query) as $key => $value) {
      $abs=str_ireplace($value,'<font color="#800000"> '.$value.'</font>',$abs);
    }

		$output.='<br/><p align="justify"><b>Abstract : </b><i>'.$abs.' </i></p>';
		$output.="<br>";		
	}





echo $output.$find;
echo '</div>';
//echo '<div id="tabs-2">
//    <p><strong>Click this tab again to close the content pane.</strong></p>
//    <p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
//  </div>';


echo '</div>';

function pt($string){
    // juste pour afficher avec retour à la ligne
echo $string."<br/>";
}

function pta($array){
    print_r($array);
    echo '<br/>';
}


?>
