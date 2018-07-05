<?php

namespace App\Payments;

use Stripe\Charge;
use Stripe\Error\InvalidRequest;
use Illuminate\Support\Collection;
use App\Exceptions\PaymentFailedException;
use Stripe\Token;

class StripePaymentGateway implements PaymentGateway
{
    /**
     * @var Collection
     */
    protected $charges;

    /**
     * @var Collection
     */
    protected $validTokens;

    public function __construct()
    {
        $this->charges = collect();
        $this->validTokens = collect();
    }

    /**
     * Charge the amount to the customer's token.
     *
     * @param int $amount
     * @param string $token
     * @return void
     */
    public function charge(int $amount, string $token): void
    {
        try {
            Charge::create([
                'amount' => $amount,
                'source' => $token,
                'currency' => 'usd',
            ]);

            $this->charges->push([
                'amount' => $amount,
                'token' => $token,
            ]);
        } catch (InvalidRequest $e) {
            throw new PaymentFailedException;
        }
    }

    /**
     * Get a valid test token.
     *
     * @return string
     */
    public function getValidTestToken(): string
    {
        return Token::create([
            'card' => [
                'number' => 4242424242424242,
                'exp_month' => 1,
                'exp_year' => date('Y') + 1,
                'cvc' => 123,
            ]
        ])->id;
    }

    /**
     * Returns all the charges this gateway has processed.
     *
     * @return Collection
     */
    public function totalCharges(): Collection
    {
        return $this->charges;
    }
}
