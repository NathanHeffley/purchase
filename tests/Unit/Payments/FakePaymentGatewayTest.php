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

        $paymentGateway->charge(500, 'test_token');
        $paymentGateway->charge(1200, 'different_token');
        $paymentGateway->charge(3000, 'test_token');

        $this->assertEquals(3500, $paymentGateway->totalChargesForToken('test_token'));
    }
}
