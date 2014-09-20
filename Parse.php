<?php

define('CONSKEY','c1d257fbcb8c4ccc7065d5f4bc38442d20db87a6efc9995edbd535cfa642fdf0');


$result = file_get_contents("https://api.tokyometroapp.jp/api/v2/datapoints?rdf:type=odpt:Station&acl:consumerKey=". CONSKEY);
$informations = json_decode($result);

// Out Format
//     @id | owl:sameAs | dc:title | ug:region | lon | lat
foreach($informations as $num => $info){

    $Info = get_object_vars($info);
    foreach($Info as $key => $value){
        if(!is_array($value)){


            if($key == "@id")
                echo $value . " | ";

            else if($key == "owl:sameAs")
                echo $value . " | ";

            else if($key == "dc:title")
                echo $value . " | ";

            else if($key == "ug:region"){
                $gisInfo = get_object_vars(json_decode(file_get_contents($value
                    . "?acl:consumerKey=" . CONSKEY)));

                echo $gisInfo["coordinates"][0] . " | ";
                echo $gisInfo["coordinates"][1] . "<br />";

            }

        }

    }

}

?>
