<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\BookingRepositoryProvider::class,
    App\Providers\BookingServiceProvider::class,
    App\Providers\PaymentGatewayContractProvider::class,
    App\Providers\PaymentServiceProvider::class,
    App\Providers\StripeGatewayProvider::class,
    App\Providers\TelescopeServiceProvider::class,
];
