<?php

namespace App\Providers;

use App\Http\Controllers\BalanceTransferController;
use App\Services\BalanceTransferService;
use Illuminate\Support\ServiceProvider;

class BalanceTransferServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BalanceTransferService::class, function ($app) {
            return new BalanceTransferService();
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
