<?php

require_once '/var/www/html/metoro/Station.php';
require_once '/var/www/html/metoro/Points.php';
require_once '/var/www/html/metoro/StationTemp.php';

# コンシューマーキー
define('CONSKEY','c1d257fbcb8c4ccc7065d5f4bc38442d20db87a6efc9995edbd535cfa642fdf0');


# ポストされて送られてきた駅名
$stationNames = array($_POST["station_1"], $_POST["station_2"]);

$points = new Points($stationNames);

$pointsGis = array();

$pointsGis = $points->getPointsGis();

$interPoint = array("lon" => ($pointsGis[0]["lon"] + $pointsGis[1]["lon"]) / 2 ,
    "lat" => ($pointsGis[0]["lat"] + $pointsGis[1]["lat"]) / 2 );

$pointList = array();

$pointsList = $points->compairByFare();

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
    zoom: 12,
        center: new google.maps.LatLng(<?php echo $interPoint["lat"];?> , <?php echo $interPoint["lon"];?>)
};

map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
var icon = 'http://maps.google.co.jp/mapfiles/ms/icons/green-dot.png';
<?php foreach($pointsGis as $num => $pointGis){ ?>
var marker_<?php echo $num; ?> = new google.maps.Marker({
      position: new google.maps.LatLng(<?php echo $pointGis["lat"]; ?>,<?php echo $pointGis["lon"]; ?>),
      animation: google.maps.Animation.DROP,
      map: map,
  });
<?php } ?>

<?php foreach($pointsList as $num => $pointGis){ ?>
var marker_<?php echo $num; ?> = new google.maps.Marker({
      position: new google.maps.LatLng(<?php echo $pointGis["lat"]; ?>,<?php echo $pointGis["lon"]; ?>),
      animation: google.maps.Animation.DROP,
      map: map,
      icon: icon,
  });
<?php } ?>

}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
  </head>
  <body>
    <div id="map-canvas" style="width:800px; height:500px"></div>
  </body>
</html>

