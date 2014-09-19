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

        $arrayTemp_0 = $this->stations[0]->getGisInfo();
        $arrayTemp_1 = $this->stations[1]->getGisInfo();

        $interPoint = array('lat' => ($arrayTemp_1['lat'] + $arrayTemp_0['lat']) / 2,
            'lon' => ($arrayTemp_1['lon'] + $arrayTemp_0['lon']) / 2);

        # 距離取得用APIのURL
        // $urlDistance = "http://lab.uribou.net/ll2dist/" . $urlDistance;

        var_dump($interPoint);
        $urlSearch = "https://api.tokyometroapp.jp/api/v2/places?rdf:type=odpt:Station&lon=" . 
            $interPoint['lat'] . "&lat=" . $interPoint['lon'] . "&radius=500&acl:consumerKey=" . CONSKEY;

        echo $urlSearch;

        $interInfo = json_decode(file_get_contents($urlSearch));

    }

    function getPointsGis(){
        $result = array();
        foreach($this->stations as $station)
            $result[] = $station->getGisInfo();

        return $result;

    }

    function compairByFare(){

        $arrayTemp_0 = array();
        $arrayTemp_1 = array();

        $resultArray = array();

        $arrayTemp_0 = $this->stations[0]->getFareInfo();
        $arrayTempName_0 = $this->stations[0]->getStationName();

        $arrayTemp_1 = $this->stations[1]->getFareInfo();
        $arrayTempName_1 = $this->stations[1]->getStationName();

        $pointList = array();

        foreach($arrayTemp_0 as $station => $fare){
            if(array_key_exists($station, $arrayTemp_1)){
                if($fare == $arrayTemp_1[$station])
                    $resultArray[$station] = $fare;
            }
        }
        
        $minFare = min($resultArray);

        $result = array_filter($resultArray,function($array) use ($minFare){
            return $array == $minFare;
        });

        if(asort($resultArray)){
            echo "<table border='1'>";
            echo "<tr><th>Point 1</th><th>待ち合わせ</th><th>Point 2</th><th>Fare</th><tr>";
            foreach($result as $station => $Fare){


                $Point = new StationTemp($station);
                $Point['fare'] = $fare;
                $pointList[] = $Point;

                echo "<tr><td>" . $arrayTempName_0 . "</td><td>" . $Point->getStationName() . "</td><td>" . $arrayTempName_1 . "</td><td>" . $Fare . "</td><tr>";
            }
        }

        return $pointList;


    }

}
?>
