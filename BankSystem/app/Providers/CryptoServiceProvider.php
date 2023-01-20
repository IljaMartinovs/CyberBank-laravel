<?php

namespace App\Providers;

use App\Http\Controllers\CryptoController;
use App\Services\CryptoService;
use Illuminate\Support\ServiceProvider;

class CryptoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->bind(CryptoController::class, function($app){
//            return new CryptoController();
//        });
        $this->app->bind(CryptoService::class, function ($app) {
            return new CryptoService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
