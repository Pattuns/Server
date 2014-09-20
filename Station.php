<?php

# コンシューマーキー
// define('CONSKEY','2b6341efbf502781c1be49bf3228cb02918742950472cc8302dc9fca452fe3aa');

require_once '/var/www/html/metoro/Station.php';

class Station
{

    public $stationId;
    # 駅情報
    public $stationInfo = array();

    public $stationAlias;

    public $stationName;

    # 運賃情報
    public $fareInfo = array();

    # 地理情報
    public $gisInfo = array();

    function __construct($stationId){

        $this->stationId = $stationId;

        $url = "https://api.tokyometroapp.jp/api/v2/datapoints/";

        $stationUrl = $url . $stationId . "?acl:consumerKey=" . CONSKEY;

        $this->stationInfo = get_object_vars(array_shift(json_decode(file_get_contents($stationUrl))));

        $this->stationAlias = $this->stationInfo["owl:sameAs"];

        $this->stationName = $this->stationInfo ["dc:title"];
$gis = get_object_vars(json_decode(file_get_contents($this->stationInfo["ug:region"] . "?acl:consumerKey=" . CONSKEY)));

        $this->gisInfo['lon'] = $gis["coordinates"][0];
        $this->gisInfo['lat'] = $gis["coordinates"][1];

        $url = "https://api.tokyometroapp.jp/api/v2/datapoints?";

        $fareFromUrl = $url ."rdf:type=odpt:RailwayFare&odpt:fromStation=" . 
            $this->stationAlias . "&acl:consumerKey=" . CONSKEY;

        $infos =  json_decode(file_get_contents($fareFromUrl));
        foreach($infos as $info){
            $fare = get_object_vars($info);
            $this->fareInfo[$fare["odpt:toStation"]] = $fare["odpt:ticketFare"];
        }

        $fareToUrl = $url ."rdf:type=odpt:RailwayFare&odpt:toStation=" . 
            $this->stationAlias . "&acl:consumerKey=" . CONSKEY;

        $infos =  json_decode(file_get_contents($fareToUrl));
        foreach($infos as $info){
            $fare = get_object_vars($info);
            $this->fareInfo[$fare["odpt:fromStation"]] = $fare["odpt:ticketFare"] ;

        }


    }

    function getStationName(){

        return $this->stationName;

    }

    function getFareInfo(){

        return $this->fareInfo;
    }

    function getGisInfo(){

        return $this->gisInfo;
    }

    function getStationId(){

        return $this->stationId;
    }
}

?>
