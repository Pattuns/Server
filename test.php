<?php

# コンシューマーキー
define('CONSKEY','2b6341efbf502781c1be49bf3228cb02918742950472cc8302dc9fca452fe3aa');

$fairUrl = "https://api.tokyometroapp.jp/api/v2/datapoints?rdf:type=odpt:RailwayFare&acl:consumerKey=" . CONSKEY;

$result = file_get_contents($fairUrl);

$body = json_decode($result);

echo count($body);

?>

