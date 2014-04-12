<?php
include('parameters_details.php');
include('../../geomap/php/countries_iso3166.php');
  
$db= $_GET["db"];//I receive the specific database as string!
$query=$_GET["query"];
$gexf=$_GET["gexf"];


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

?>


