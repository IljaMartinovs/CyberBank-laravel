<?php

namespace App\Providers;

use App\Http\Controllers\CryptoController;
use App\Services\CryptoService;
use Illuminate\Support\ServiceProvider;

class CryptoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CryptoService::class, function ($app) {
            return new CryptoService();
        });
    }

    public function boot()
    {
        //
    }
}
