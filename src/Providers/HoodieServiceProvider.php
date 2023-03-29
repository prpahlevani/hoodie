<?php

namespace Motrack\Hoodie\Providers;

use Illuminate\Support\ServiceProvider;
use Motrack\Hoodie\Interfaces\ApiResponderInterface;

class HoodieServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('Hoodie' , ApiResponderInterface::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
