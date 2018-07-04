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

    /**
     * @var PaymentGateway
     */
    protected $paymentGateway;

    public function setUp()
    {
        parent::setUp();

        Mail::fake();
        $this->paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }
    /** @test */
    public function customer_can_purchase_a_product()
    {
        $this->withoutExceptionHandling();

        $product = factory(Product::class)->create(['price' => 2450]);

        $testToken = $this->paymentGateway->getValidTestToken();

        $response = $this->json('POST', "/products/{$product->id}/orders", [
            'email' => 'john@example.com',
            'token' => $testToken,
        ]);

        $response->assertStatus(201);

        $this->assertEquals(2450, $this->paymentGateway->totalChargesForToken($testToken));

        Mail::assertSent(ProductEmail::class, function ($email) use ($product) {
            $this->assertTrue($email->hasTo('john@example.com'));
            $this->assertTrue($email->product->is($product));
            return true;
        });
    }

    /** @test */
    public function email_is_not_sent_if_payment_fails()
    {
        $product = factory(Product::class)->create(['price' => 2450]);

        $response = $this->json('POST', "/products/{$product->id}/orders", [
            'email' => 'john@example.com',
            'token' => 'invalid_token',
        ]);

        $response->assertStatus(422);
        Mail::assertNothingSent();
    }
}
