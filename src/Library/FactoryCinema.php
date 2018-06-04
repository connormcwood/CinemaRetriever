<?php 
namespace Connormcwood\CinemaRetriever\Library;

use Connormcwood\CinemaRetriever\Library\VueCinema;
use Connormcwood\CinemaRetriever\Library\CineworldCinema;

class FactoryCinema
{
	public static function build($type)
	{
		switch($type) {
			case "vue":
				return new VueCinema();
				break;
			case "cineworld":
				return new CineworldCinema();
				break;
			default:
				return new \Exception("Invalid Type");	
				break;
		}    		
	}
}