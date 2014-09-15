<?php

$result = file_get_contents("https://api.tokyometroapp.jp/api/v2/datapoints?rdf:type=odpt:RailwayFare&odpt:fromStation=odpt.Station:TokyoMetro.Ginza.Asakusa&acl:consumerKey=2b6341efbf502781c1be49bf3228cb02918742950472cc8302dc9fca452fe3aa");

$infomations = json_decode($result);

echo "<table>";
foreach($infomations as $infomation){
    // var_dump($info);
    // echo "</ br>";
    //
    $info = get_object_vars($infomation);
    echo "<tr><td>" . $info["odpt:toStation"]
        . "</td><td>" . $info["odpt:ticketFare"] . "</td></tr>";
}
echo "</table>";

?>
