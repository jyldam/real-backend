<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $helpers = glob(app_path('Helpers.php'));

        if (is_array($helpers) && count($helpers) > 0) {
            require_once $helpers[0];
            return;
        }

        require_once $helpers;
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
