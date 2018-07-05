<?php

namespace App\Payments;

use Illuminate\Support\Collection;

interface PaymentGateway
{
    /**
     * Charge the amount to the customer's token.
     *
     * @param int $amount
     * @param string $token
     * @return void
     */
    public function charge(int $amount, string $token): void;

    /**
     * Get a valid test token.
     *
     * @return string
     */
    public function getValidTestToken(): string;

    /**
     * Returns all the charges this gateway has processed.
     *
     * @return Collection
     */
    public function totalCharges(): Collection;
}
