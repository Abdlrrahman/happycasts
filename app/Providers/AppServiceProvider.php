<?php

namespace HappyCasts\Providers;

use Blade;
use URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        };

        Blade::if('hasStartedSeries', function ($series) {
            return auth()->user()->hasStartedSeries($series);
        });

        Blade::if('admin', function () {
            return auth()->user()->isAdmin();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
