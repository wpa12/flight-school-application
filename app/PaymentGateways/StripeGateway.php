<?php

namespace App\PaymentGateways;

use App\Contracts\PaymentGatewayContract;
use Stripe\PaymentIntent;
use Stripe\StripeClient;

class StripeGateway implements PaymentGatewayContract
{
    private PaymentIntent $paymentIntent;
    public function __construct(private StripeClient $client)
    {}

    /**
     * Create a payment intent
     *
     * @param float $amount
     * @param array $metadata
     * @return void
     */
    public function createPayment(float $amount, array $metadata = []): void
    {
        $this->paymentIntent = $this->client->paymentIntents->create([
            'amount' => $amount * 100,
            'currency' => config('services.stripe.currency'),
            'payment_method_types' => ['card'],
            'metadata' => $metadata,
        ]);
    }

    /**
     * Charge a payment
     *
     * @param float $amount
     * @param array $metadata
     * @return PaymentIntent
     */
    public function charge(): PaymentIntent
    {
        try {
            return $this->paymentIntent->confirm(['payment_method' => 'pm_card_visa']);
            
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}