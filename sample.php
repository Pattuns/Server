<?php

require_once '/var/www/html/metoro/Station.php';
require_once '/var/www/html/metoro/Points.php';

# コンシューマーキー
define('CONSKEY','2b6341efbf502781c1be49bf3228cb02918742950472cc8302dc9fca452fe3aa');


# ポストされて送られてきた駅名
$stationNames = array($_POST["station_1"], $_POST["station_2"]);

$points = new Points($stationNames);

$pointsGeo = array();

$pointsGeo = $points->getPointsGeo();

$interPoint = array(($pointsGeo[0]["lon"] + $pointsGeo[1]["lon"]) / 2 ,
    ($pointsGeo[0]["lat"] + $pointsGeo[1]["lat"]) / 2 );

var_dump($interPoint);

// $points->compairByFare();
//
// $points->compairByDistance();

?>

<!DOCTYPE html>
<html>
  <head>
    <title>compairByFare</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script>
var map;
function initialize() {
    var mapOptions = {
    zoom: 8,
        center: new google.maps.LatLng(34.397, 150.644)
};

map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
  </head>
  <body>
    <div id="map-canvas" style="width:800px; height:500px"></div>
  </body>
</html>

