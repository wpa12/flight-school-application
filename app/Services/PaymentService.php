<?php

namespace App\Services;

use App\Contracts\PaymentGatewayContract;
use Stripe\PaymentIntent;

class PaymentService
{
    public function __construct(private readonly PaymentGatewayContract $paymentGateway)
    {}

    /**
     * Charge a payment
     *
     * @param float $amount
     * @return bool
     */
    public function charge(): PaymentIntent
    {
        return $this->paymentGateway->charge();
    }

    public function createPaymentIntent(float $amount, array $metadata = []): PaymentIntent
    {
        return $this->paymentGateway->createPayment($amount, $metadata);
    }
}