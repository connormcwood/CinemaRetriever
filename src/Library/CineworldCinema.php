<?php
namespace Connormcwood\CinemaRetriever\Library;

use Connormcwood\CinemaRetriever\Library\BaseCinema;

class CineworldCinema extends BaseCinema {
    private $key;
    private $id;
    private $urls = array(
        'cinema' => 'https://www.cineworld.co.uk/syndication/cinemas.xml',
        'films' => 'https://www.cineworld.co.uk/syndication/film_times.xml'
    );

    /**
     *
     * @param null $id
     * @param null $postcode
     * @return mixed
     */
    public function getCinema($id = null, $postcode = null) {       
        if(!empty($id)) {
            $this->id = $id;
            $cinema_return = $this->makeCinemaRequest('cinema');
            if(!empty($cinema_return)) {
                $cinemas = $cinema_return;
                return $cinemas;
            }
        }
    }

    /* Iterates through XML string, pulls data only by CINEMA ID,
    and returns data in array */
    protected function getXMLasArray($resp, $type) {
        $xml_string = simplexml_load_string($resp);
        $return_array = array();
        if($type == 'films') {
            foreach($xml_string->row as $f => $element) {
                if($element->attributes()['key'] == $this->id) {
                    $return_array[] = $element;
                }
            }
            return $return_array;
        } elseif($type == 'cinema') {            
            foreach($xml_string->cinema as $k => $element) {
                if($element->attributes()['id'] == $this->id) {
                    return $return_array = $element;
                }            
            }
        }
        
    }
    public function getFilms($id) {
        $this->id = $id;
        $films = $this->makeRequest('films');
        //write_log ("VUE DEBUG FILMS");
        //write_log ($films);
        if (!$films) {
            return false;
        } elseif (!empty($films)) {
            return $films;
        } else {
            return false;
        }
    }    
    public function makeRequest($type, $params = array()) {
        $url = $this->urls[$type];
        if (empty($url)) return;
        $params_str = '';
        if (!empty($params)) {
            $params_str = $params;
        }
        $resp = $this->makeCurlRequest($url);
        $return_array = $this->getXMLasArray($resp, $type);
        //$return_array = json_decode($resp, true);
        //write_log ($return_array);
        if (in_array('errors', $return_array)) {
            return false;
        } else {
            return $return_array;
        }
    }
}