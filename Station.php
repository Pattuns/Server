<?php

# コンシューマーキー
// define('CONSKEY','2b6341efbf502781c1be49bf3228cb02918742950472cc8302dc9fca452fe3aa');

require_once '/var/www/html/metoro/Station.php';

class Station
{

    # 駅情報
    public $stationInfo = array();

    public $stationAlias;

    public $stationName;

    # 運賃情報
    public $fareInfo = array();

    # 地理情報
    public $geoinfo = array();

    function __construct($stationId){

        $url = "https://api.tokyometroapp.jp/api/v2/datapoints/";

        $stationUrl = $url . $stationId . "?acl:consumerKey=" . CONSKEY;

        $this->stationInfo = get_object_vars(array_shift(json_decode(file_get_contents($stationUrl))));

        $this->stationAlias = $this->stationInfo["owl:sameAs"];

        $this->stationName = $this->stationInfo ["dc:title"];

        $geo = get_object_vars(json_decode(file_get_contents($this->stationInfo["ug:region"] . "?acl:consumerKey=" . CONSKEY)));

        $this->geoInfo['lat'] = $geo["coordinates"][0];
        $this->geoInfo['lon'] = $geo["coordinates"][1];

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

    function getGeoInfo(){

        return $this->geoInfo;
    }
}

?>
