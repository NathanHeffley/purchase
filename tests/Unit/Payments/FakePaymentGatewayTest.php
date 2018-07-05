<?php

namespace Tests\Unit\Payments;

use Tests\TestCase;
use App\Payments\PaymentGateway;
use App\Payments\FakePaymentGateway;

class FakePaymentGatewayTest extends TestCase
{
    use PaymentGatewayTests;

    /**
     * Returns the payment gateway to be used for tests.
     *
     * @return PaymentGateway
     */
    protected function paymentGateway(): PaymentGateway
    {
        return new FakePaymentGateway();
    }

    /** @test */
    public function can_get_total_charges_for_a_specific_token()
    {
        $paymentGateway = new FakePaymentGateway;

        $testToken = $paymentGateway->getValidTestToken();

        $paymentGateway->charge(500, $testToken);
        $paymentGateway->charge(1200, $paymentGateway->getValidTestToken());
        $paymentGateway->charge(3000, $testToken);

        $this->assertEquals(3500, $paymentGateway->totalChargesForToken($testToken));
    }
}
