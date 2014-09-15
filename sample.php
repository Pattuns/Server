<?php

require_once '/var/www/html/metoro/Station.php';
require_once '/var/www/html/metoro/Points.php';


# コンシューマーキー
define('CONSKEY','2b6341efbf502781c1be49bf3228cb02918742950472cc8302dc9fca452fe3aa');

# ポストされて送られてきた駅名
$stationNames = array($_POST["station_1"], $_POST["station_2"]);

$points = new Points($stationNames);

$points->compairByFare();

?>
