<?php

namespace Motrack\Hoodie\Providers;

use Motrack\Hoodie\ApiResponder;
use Illuminate\Support\ServiceProvider;
use Motrack\Hoodie\Interfaces\ApiResponderInterface;

class HoodieServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ApiResponderInterface::class , ApiResponder::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
