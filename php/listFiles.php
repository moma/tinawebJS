<?php
header ("Content-Type:text/html"); 
//$string = getcwd();
//$string = str_replace("/php","",$string);

$string=dirname(dirname(getcwd())); // ProjectExplorer folder name: /var/www/ademe

$files = getDirectoryList($string."/data");

//$html = "<select onchange='start(this.value);'>";
$scriptname=end(explode('/',$_SERVER['PHP_SELF']));
$scriptpath=str_replace($scriptname,'',$_SERVER['PHP_SELF']);
$scriptpath=str_replace('php/','',$scriptpath);
$scriptpath=str_replace($_GET["url"],'',$scriptpath);
$html = "<select style='width:150px;' onchange='
                window.location=\"http://$_SERVER[SERVER_NAME]$scriptpath\"+\"?file=\"+this.value;
        '>";
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

?>

