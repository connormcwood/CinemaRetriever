<?php 
namespace Connormcwood\CinemaRetriever\Library;

use Connormcwood\CinemaRetriever\Library\BaseCinema;

class VueCinema extends BaseCinema
{
    private $key;

    private $urls = array(
        'cinema' => 'https://api.myvue.com/cinemas/',
        'films' => 'https://api.myvue.com/singlesite/',
        'singlefilms' => 'https://api.myvue.com/films/',
    );
    private $id;

    public function __construct() {
    //parent::class();
    }

    public function getCinema($id = null) {
            if (!empty($id)) {
                $this->id = $id;
                $cinema_return = $this->makeRequest('cinema');
                if (!empty($cinema_return)) {
                    $cinemas = $cinema_return['Cinemas'];
                         //print_r($cinemas);
                    foreach ($cinemas as $cinema){
                        //print_r($cinema);
                        if ($cinema['LegacyCinemaId'] == $this->vue_id){
                          return $cinema;
                      }
                  }
              }
          }
    }

    public function getFilms($id = null) {
        $this->id = $id;
        //Retrieves Films and Records the Films IDs
        $films = $this->makeRequest('films', '/'.$this->id);
        //Retrieves Film Information from set Film Ids
        $singlefilms = $this->makeRequest('singlefilms', '/' . $this->id);
        $combinedFilms = [];
        foreach($films as $k => $film) {
            $combinedFilms[] = array_merge($film, $singlefilms[$film['FilmId']]);
        }
        if($combinedFilms === null || count($combinedFilms) < 1) {
            return false;
        } else {
            return $combinedFilms;
        }
    }
    public function makeRequest($type, $params = array()) {
        $url = $this->urls[$type];
        if (empty($url)) return;
        $params_str = '';
        if (!empty($params)) {
            $params_str = $params;
        }
        $url = $url .$this->key.$params_str;
        $resp = $this->makeCurlRequest($url);
        $respObj = json_decode($resp, true);
        $filmId = [];
        if (in_array('errors', $respObj)) {
            return false;
        }
        
        if($type == 'films') {    
            foreach($respObj['FilmListContainer']['Performances'] as $k => $film) {
                $filmId[] = $film['FilmId'];
            }
            $this->ids = $filmId;
            return $respObj['FilmListContainer']['Performances'];
        } else if($type == 'singlefilms') {    
            $filmDetails = [];  
            foreach($respObj['Films'] as $k => $film) {
                if(in_array($film['BookingPartnerFilmId'], $this->ids)) {
                    $filmDetails[$film['BookingPartnerFilmId']] = $film;
                }
            }
            return $filmDetails;
        }
    }
}