<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\PaymentGatewayContractProvider::class,
    App\Providers\PaymentServiceProvider::class,
    App\Providers\StripeGatewayProvider::class,
    App\Providers\UserRepositoryProvider::class,
    App\Providers\UserServiceProvider::class,
];
