<?php 
namespace Connormcwood\CinemaRetriever\Library;

abstract class BaseCinema
{
    private $key;
    private $id;
    private $urls;

    abstract public function makeRequest($type, $params = array());
    abstract public function getFilms($id);       

    protected function makeCurlRequest($url){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL            => $url,
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;   
    }
}