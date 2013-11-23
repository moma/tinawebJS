<?php
// Common parameters for all function proposing insight into the corpora
$mainpath=dirname(dirname(getcwd()))."/data/"; // -> /var/www/ademe/data/
$dbname=getDB($mainpath);//'homework-20750-1-homework-db.db';
$base = new PDO("sqlite:" .$mainpath.$dbname);
$max_item_displayed=6;

/*
 * This function gets the first db name in the data folder
 * IT'S NOT SCALABLE! (If you want to use several db's)
 */
function getDB ($directory)  {
    //$results = array();
    $result = "";
    $handler = opendir($directory);
    while ($file = readdir($handler)) {
      if ($file != "." && $file != ".." 
              && 
        ((strpos($file,'.db~'))==false && (strpos($file,'.db'))==true )
              || 
        ((strpos($file,'.sqlite~'))==false && (strpos($file,'.sqlite'))==true)
      ) {
            //$results[] = $file;
            $result = $file;
            break;
      }
    }
    closedir($handler);
    //return $results;
    return $result;
}

?>
