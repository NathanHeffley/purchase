<?php

namespace App\Payments;

use Illuminate\Support\Collection;

class FakePaymentGateway implements PaymentGateway
{
    /**
     * @var Collection
     */
    protected $charges;

    public function __construct()
    {
        $this->charges = collect();
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
        $this->charges->push([
            'amount' => $amount,
            'token' => $token,
        ]);
    }

    /**
     * Get a valid test token.
     *
     * @return string
     */
    public function getValidTestToken(): string
    {
        return 'valid_test_token';
    }

    /**
     * Returns the total value of charges this gateway has faked for a specific token.
     *
     * @param string $token
     * @return int
     */
    public function totalChargesForToken(string $token): int
    {
        return $this->charges->filter(function ($charge) use ($token) {
            return $charge['token'] === $token;
        })->sum('amount');
    }
}
