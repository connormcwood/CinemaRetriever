<?php

namespace Connormcwood\CinemaRetriever\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Connormcwood\CinemaRetriever\Library\FactoryCinema;

class CinemaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function ShowCinema($type)
    {
        return FactoryCinema::build($type)->getFilms(48);
    }
}
