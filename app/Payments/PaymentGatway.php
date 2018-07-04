<?php

namespace App\Payments;

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
}
