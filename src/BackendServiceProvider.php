<?php 
namespace Connormcwood\CinemaRetriever;
/**/
/**
 *
 * @author Harrison Bennett <harrisongbennett@gmail>
 */

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class BackendServiceProvider extends ServiceProvider{


    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function boot()
    {
        $this->setupRoutes($this->app->router);		
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Connormcwood\CinemaRetriever\Http\Controllers'], function($router)
        {            
            $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
        });
    }
}