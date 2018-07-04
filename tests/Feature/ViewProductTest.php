<?php

namespace Tests\Feature;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_a_product()
    {
        $this->withoutExceptionHandling();

        $product = factory(Product::class)->create([
            'name' => 'The Best Product',
            'description' => 'This is the best, most awesome product ever.',
            'price' => 2500,
        ]);

        $response = $this->get("/products/{$product->id}");

        $response->assertStatus(200);
        $response->assertSee('The Best Product');
        $response->assertSee('This is the best, most awesome product ever.');
        $response->assertSee('$25.00');
    }
}
