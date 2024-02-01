<?php

namespace core\classes;

$root = $_SERVER["DOCUMENT_ROOT"] . '/buildlookmvc';
require_once  $root . '/config.php';



class Api
{

    private $apiKey= API_KEY;
    private $apiUrl = API_URL;


    public function __construct()
    {
     //   $this->apiKey = $apiKey;
    }

    public function getWeatherByCity($city, $country)
    {
        $url = $this->apiUrl . "?q=$city,$country&appid=$this->apiKey";

        $jsonArray = json_decode(file_get_contents($url));

        $data = $jsonArray->main;

        $result =  intVal($data->temp - 273.15);

        echo $result;
    }
}

