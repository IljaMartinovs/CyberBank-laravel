<?php

namespace App\Providers;

use App\Http\Controllers\AccountController;
use App\Services\AccountService;
use Illuminate\Support\ServiceProvider;

class AccountServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AccountService::class, function ($app) {
            return new AccountService();
        });
    }

    public function boot()
    {
        //
    }
}
