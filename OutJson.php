<?php

require_once '/var/www/html/metoro/Station.php';
require_once '/var/www/html/metoro/Points.php';
require_once '/var/www/html/metoro/StationTemp.php';

# コンシューマーキー
define('CONSKEY','c1d257fbcb8c4ccc7065d5f4bc38442d20db87a6efc9995edbd535cfa642fdf0');


# ポストされて送られてきた駅名
$stationNames = array($_GET["station_1"], $_GET["station_2"]);

$points = new Points($stationNames);

$pointsGis = array();

$pointsGis = $points->getPointsGis();

$interPoint = array("lon" => ($pointsGis[0]["lon"] + $pointsGis[1]["lon"]) / 2 ,
    "lat" => ($pointsGis[0]["lat"] + $pointsGis[1]["lat"]) / 2 );

$pointList = array();

$pointsList = $points->compairByFare();

echo "{";
foreach($points->stations as $station){
    echo "{";
    echo "type:point,";
    echo "name:" . $station->getStationName() . ",";
    echo "gis:{";
        foreach($station->getGisInfo() as $type => $value){
            echo $type . ":" . $value . ",";
        }
    echo "}";
    echo"},";
}
echo "}";




?>
