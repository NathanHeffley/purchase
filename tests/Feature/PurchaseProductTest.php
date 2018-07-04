<?php

namespace Tests\Feature;

use App\Product;
use Tests\TestCase;
use App\Mail\ProductEmail;
use App\Payments\PaymentGateway;
use App\Payments\FakePaymentGateway;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function customer_can_purchase_a_product()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        $paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $paymentGateway);

        $product = factory(Product::class)->create([
            'price' => 2450,
        ]);

        $testToken = $paymentGateway->getValidTestToken();

        $response = $this->json('POST', "/products/{$product->id}/orders", [
            'email' => 'john@example.com',
            'token' => $testToken,
        ]);

        $response->assertStatus(201);

        $this->assertEquals(2450, $paymentGateway->totalChargesForToken($testToken));

        Mail::assertSent(ProductEmail::class, function ($mail) {
            return $mail->hasTo('john@example.com');
        });
    }
}
