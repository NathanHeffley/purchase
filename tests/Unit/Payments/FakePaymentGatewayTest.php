<?php

namespace Tests\Unit\Payments;

use App\Payments\FakePaymentGateway;
use Tests\TestCase;

class FakePaymentGatewayTest extends TestCase
{
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
