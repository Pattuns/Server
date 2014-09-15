<?php

require '/var/www/html/metoro/Station.php';

# コンシューマーキー
// define('CONSKEY','2b6341efbf502781c1be49bf3228cb02918742950472cc8302dc9fca452fe3aa');

# ポストされて送られてきた駅名
$stationName = $_POST["station"];

// #駅情報取得用urlの組み立て
// $stationUrl = "https://api.tokyometroapp.jp/api/v2/datapoints?rdf:type=odpt:Station&owl:sameAs="
//     . $stationName . "&acl:consumerKey=" . CONSKEY;
//
// $stationResult = file_get_contents($stationUrl);
//
// $stationInfo = json_decode($stationResult);
//
// $stationInfoDetail = get_object_vars($stationInfo[0]);

$station = new Station($stationName);

$stationInfo = get_object_vars(array_shift($station->stationInfo));
 echo "<h1>" . $stationInfo["dc:title"] ."</h1>";
//
// # 運賃情報取得用urlの組み立て
// $fairUrl = "https://api.tokyometroapp.jp/api/v2/datapoints?rdf:type=odpt:RailwayFare&odpt:fromStation="
//     . $stationName . "&acl:consumerKey=" . CONSKEY;
//
// # APIを叩いて結果を取得する
// $result = file_get_contents($fairUrl);
//
// $infomations = json_decode($result);



echo "<table>";
foreach($station->fairInfo as $infomation){
    $info = get_object_vars($infomation);
    echo "<tr><td>" . $info["odpt:toStation"]
        . "</td><td>" . $info["odpt:ticketFare"] . "</td></tr>";
}
echo "</table>";

?>
