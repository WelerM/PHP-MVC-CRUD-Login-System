<?php

namespace core\classes;

$root = $_SERVER["DOCUMENT_ROOT"] . '/buildlookmvc';
require_once  $root . '/config.php';



class Api
{

    private $apiKey = API_KEY;
    private $apiUrl = API_URL;
    private $api_countrycity_key = API_COUNTRYCITY_KEY;
    private $api_countrycity_url = API_COUNTRYCITY_URL;


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

    public function getCountries($country_code = null, $state_code = null)
    {

        // Construct the URL with the country code
        $url = $this->api_countrycity_url;

        $options = [
            'http' => [
                'header' => "X-CSCAPI-KEY: $this->api_countrycity_key"
            ]
        ];
        $context = stream_context_create($options);

        $response = null;





        if ($country_code != null && $state_code != null) {//Will return cities
                  //-country=${selected_country}/states/${selected_state}/cities
            $response = file_get_contents("$url/$country_code/states/$state_code/cities", false, $context);

        } else if ($country_code != null) {

            $response = file_get_contents($url . '/' . $country_code . '/states', false, $context);

        } else {

            $response = file_get_contents($url, false, $context);
        }

        return json_decode($response, true);
    }
}
