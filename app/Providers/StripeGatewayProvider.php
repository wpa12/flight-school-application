<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Stripe\StripeClient;
use App\PaymentGateways\StripeGateway;

class StripeGatewayProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bindIf(StripeGateway::class, function ($app) {
            return new StripeGateway(new StripeClient(config('services.stripe.secret_key'))); // bind the stripe client with the stripegateway
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
