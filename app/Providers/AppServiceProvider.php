<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\MultiUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Utils\JsonUtil;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $jsonResponse = JsonUtil::getJsonFromPublic('location.json');
        $locationData = $jsonResponse->getData(true); 
        // Share with all views
        View::share('locationData', $locationData);
    }
}
