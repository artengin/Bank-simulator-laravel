<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        URL::forceScheme('https');
    }

    public function boot(): void
    {
        if (config('app.env') === 'local') {
            App::register(\RonasIT\Support\EntityGeneratorServiceProvider::class);
        }
    }
}
