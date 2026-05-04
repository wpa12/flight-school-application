<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\PaymentGatewayContract;
use App\PaymentGateways\StripeGateway;

class PaymentGatewayContractProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bindIf(PaymentGatewayContract::class, function ($app) {
            return $app->make(StripeGateway::class); // bind the StripeGateway with the PaymentGatewayContract
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
