<?php

namespace Tests\Unit\Mail;

use App\Mail\ProductEmail;
use App\Product;
use Tests\TestCase;

class ProductEmailTest extends TestCase
{
    /** @test */
    public function email_has_a_subject()
    {
        $product = factory(Product::class)->make();

        $email = new ProductEmail($product);

        $this->assertEquals('Your Product Is Here!', $email->build()->subject);
    }

    /** @test */
    public function email_has_a_link_to_the_product_download_page()
    {
        $product = factory(Product::class)->make(['download_link' => 'https://download.example/link']);

        $email = new ProductEmail($product);
        $email->build();
        $rendered = view($email->view, $email->buildViewData())->render();

        $this->assertContains('https://download.example/link', $rendered);
    }
}
