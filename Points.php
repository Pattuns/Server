<?php

require_once '/var/www/html/metoro/Station.php';

class Points
{

    public $stations = array();

    public $compairInfo = array();

    function __construct($stationIds){

        foreach($stationIds as $stationId){

            $station = new Station($stationId);

            array_push($this->stations, $station);

        }

    }

    function printAllStationName(){

        foreach($this->stations as $station){
            echo $station->getStationName() . "<br />";

        }

    }

    function compairByDistance(){

        $arrayTemp_0 = array();
        $arrayTemp_1 = array();

        $resultArray = array();

        $arrayTemp_0 = $this->stations[0]->getGeoInfo();
        $arrayTemp_1 = $this->stations[0]->getGeoInfo();

        $urlParametor = "ll1=" . $arrayTemp_0['lat'] . "," . $arrayTemp_0['lon'] . 
            "&ll2=" . $arrayTemp_1['lat'] . "," . $arrayTemp_1['lon'];

        # 距離取得用APIのURL
        $urlDistance = "http://lab.uribou.net/ll2dist/";

    }

    function compairByFare(){

        $arrayTemp_0 = array();
        $arrayTemp_1 = array();

        $resultArray = array();

        $arrayTemp_0 = $this->stations[0]->getFareInfo();
        $arrayTempName_0 = $this->stations[0]->getStationName();

        $arrayTemp_1 = $this->stations[1]->getFareInfo();
        $arrayTempName_1 = $this->stations[1]->getStationName();

        foreach($arrayTemp_0 as $station => $fare){
            if(array_key_exists($station, $arrayTemp_1)){
                if($fare == $arrayTemp_1[$station])
                    $resultArray[$station] = $fare;
            }
        }

        if(asort($resultArray)){
            echo "<table border='1'>";
            echo "<tr><th>Point 1</th><th>待ち合わせ</th><th>Point 2</th><th>Fare</th><tr>";
            foreach($resultArray as $station => $Fare)
                echo "<tr><td>" . $arrayTempName_0 . "</td><td>" . $station . "</td><td>" . $arrayTempName_1 . "</td><td>" . $Fare . "</td><tr>";
        }


    }

}
?>
