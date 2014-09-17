<?php
require_once '/var/www/html/metoro/Station.php';

class StationTemp
{

    public $stationId;

    public $stationAlias;

    public $gisInfo = array();

    function __construct($stationAlias){

        $this->stationAlias = $stationAlias;

        $url = "https://api.tokyometroapp.jp/api/v2/datapoints?";

        $stationUrl = $url . "rdf:type=odpt:Station&owl:sameAs=" . $stationAlias . "&acl:consumerKey=" . CONSKEY;

        $this->stationInfo = get_object_vars(array_shift(json_decode(file_get_contents($stationUrl))));

        $gis = get_object_vars(json_decode(file_get_contents($this->stationInfo["ug:region"] . "?acl:consumerKey=" . CONSKEY)));

        $this->gisInfo['lon'] = $gis["coordinates"][0];
        $this->gisInfo['lat'] = $gis["coordinates"][1];

    }

    function printGis(){

        echo "lon:" . $gisInfo['lon'] . " lat:" .$gisInfo['lat'] . "<br />";
    }

    function getGis(){
        return $this->gisInfo;

    }

}

?>



