<?php

namespace Tests\Unit\Payments;

use App\Payments\PaymentGateway;
use Illuminate\Support\Collection;
use App\Exceptions\PaymentFailedException;

trait PaymentGatewayTests
{
    /**
     * Returns the payment gateway to be used for tests.
     *
     * @return PaymentGateway
     */
    abstract protected function paymentGateway(): PaymentGateway;

    /** @test */
    public function charges_with_valid_test_tokens_are_successful()
    {
        $paymentGateway = $this->paymentGateway();

        $testToken = $paymentGateway->getValidTestToken();

        $paymentGateway->charge(1250, $testToken);

        tap($paymentGateway->totalCharges(), function (Collection $totalCharges) use ($testToken) {
            $this->assertCount(1, $totalCharges);
            $this->assertEquals(1250, $totalCharges->first()['amount']);
            $this->assertEquals($testToken, $totalCharges->first()['token']);
        });
    }

    /** @test */
    function charges_with_an_invalid_payment_token_fail()
    {
        $paymentGateway = $this->paymentGateway();

        try {
            $paymentGateway->charge(1250, 'invalid-token');
        } catch (PaymentFailedException $e) {
            $this->assertCount(0, $paymentGateway->totalCharges());
            return;
        }

        $this->fail("Charging with an invalid payment token did not throw a PaymentFailedException.");
    }
}
