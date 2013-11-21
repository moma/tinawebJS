<?php

header('Content-Type: application/json');

include('parameters_details.php');
include('cortext_countries.php');


$sql="select count(*),data from ISIC1Country GROUP BY data ORDER BY count(*) DESC";

$norm_country=array();
foreach ($base->query($sql) as $row) {
    $code=$country[$row["data"]];
    //$norm_country[$code] = array();//$row["count(*)"];
    $info=array();
    $info["value"]=$row["count(*)"];
    $info["attrs"] = array();
    $info["attrs"]["href"] = "#";
    $info["tooltip"] = array();
    
    //$info["tooltip"]["content"] = "%3Cspan%20style%3D%22font-weight%3Abold%3B%22%3E".$code."%3C%2Fspan%3E%3Cbr%2F%3Enb_Publishers%20%3A".$row["count(*)"];
    //$info["tooltip"]["content"] = "&lt;span&gt;".$code."&lt;&#47;span&gt;&lt;br;&lt;&gt;".$row["count(*)"];
    $info["tooltip"]["content"] = "<span style='font-weight=bold;'>".$code."</span><br/>Publications: ".$row["count(*)"];
    $norm_country[$code]=$info;
}

echo json_encode($norm_country);

?>
