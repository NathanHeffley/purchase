<?php

namespace Tests\Unit\Payments;

use Tests\TestCase;
use App\Payments\PaymentGateway;
use App\Payments\StripePaymentGateway;

/**
 * @group integration
 */
class StripePaymentGatewayTest extends TestCase
{
    use PaymentGatewayTests;

    /**
     * Returns the payment gateway to be used for tests.
     *
     * @return PaymentGateway
     */
    protected function paymentGateway(): PaymentGateway
    {
        return new StripePaymentGateway();
    }
}
