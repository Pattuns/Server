
<?php

define('CONSKEY','c1d257fbcb8c4ccc7065d5f4bc38442d20db87a6efc9995edbd535cfa642fdf0');


$result = file_get_contents("https://api.tokyometroapp.jp/api/v2/datapoints?rdf:type=odpt:Station&acl:consumerKey=". CONSKEY);
$informations = json_decode($result);
var_dump($informations);

echo "<table>";
foreach($informations as $info){

    $Info = get_object_vars($info);
    foreach($Info as $key => $value){

        echo "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";

    }

}

    echo "</table>";
?>
