<?php
header ("Content-Type:text/html"); 
//$string = getcwd();
//$string = str_replace("/php","",$string);

$string=dirname(dirname(getcwd())); // ProjectExplorer folder name: /var/www/ademe
$files = getDirectoryList($string."/data");

$windowloc="http://".$_SERVER[SERVER_NAME].$_GET["extra"];
$javascript="onchange='window.location=\"".$windowloc."\"+\"?file=\"+this.value;'";
//pr("<pre>".$javascript."</pre>");
$html = "<select style='width:150px;' ".$javascript.">";
$html.="<option selected>[Select your Graph]</option>";
$filesSorted=array();
foreach($files as $file){
    array_push($filesSorted,$file);
}
sort($filesSorted);
foreach($filesSorted as $file){
    $html.="<option>$file</option>";
}
$html.="</select>";
echo $html;

function getDirectoryList ($directory)  {
    $results = array();
    $handler = opendir($directory);
    while ($file = readdir($handler)) {
      if ($file != "." && $file != ".." && 
         (strpos($file,'.gexf~'))==false && 
         (strpos($file,'.gexf'))==true) {
        $results[] = $file;
      }
    }
    closedir($handler);
    return $results;
}
function pr($msg) {
    echo $msg . "<br>";
}

?>

