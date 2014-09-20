<?php

define('CONSKEY','c1d257fbcb8c4ccc7065d5f4bc38442d20db87a6efc9995edbd535cfa642fdf0');


$result = file_get_contents("https://api.tokyometroapp.jp/api/v2/datapoints?rdf:type=odpt:RailwayFare&acl:consumerKey=". CONSKEY);
$informations = json_decode($result);

// Out Format
//     @id | owl:sameAs | dc:title | ug:region | lon | lat
foreach($informations as $num => $info){

    echo "<table>";
    $Info = get_object_vars($info);
    foreach($Info as $key => $value){
        if(!is_array($value)){

            echo "<tr><td>" . $key . "</td><td>" . $value ."</td></tr>";


            if($key == "@id")
                echo $value . " | ";

            else if($key == "odpt:fromStation")
                echo $value . " | ";

            else if($key == "odpt:toStation")
                echo $value . " | ";

            else if($key == "odpt:ticketFare")
                echo $value . " | ";

            else if($key == "odpt:childTicketFare")
                echo $value . " | ";

            else if($key == "odpt:icCardFare")
                echo $value . " | ";

            else if($key == "odpt:childIcCardFare")
                echo $value . "<br />";

        }

    }



}

?>
