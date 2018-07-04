<?php

namespace App\Mail;

use App\Product;
use Illuminate\Mail\Mailable;

class ProductEmail extends Mailable
{
    /**
     * @var Product
     */
    public $product;

    /**
     * Create a new email instance.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Build the email.
     * @return ProductEmail
     */
    public function build(): ProductEmail
    {
        return $this->view('emails.product-email')->subject('Your Product Is Here!');
    }
}
