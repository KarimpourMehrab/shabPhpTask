<?php

namespace App\Providers;

use App\Services\Delivery\DeliveryServiceResolver;
use Illuminate\Support\ServiceProvider;

class DeliveryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('deliveryService', function () {
            return new DeliveryServiceResolver();
        });
    }
}
