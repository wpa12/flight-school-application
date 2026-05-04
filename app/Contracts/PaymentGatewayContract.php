<?php

namespace App\Contracts;

use Stripe\PaymentIntent;

interface PaymentGatewayContract
{
    public function charge(): PaymentIntent;
}