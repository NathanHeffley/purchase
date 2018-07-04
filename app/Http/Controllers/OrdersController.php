<?php

namespace App\Http\Controllers;

use App\Product;
use App\Mail\ProductEmail;
use App\Payments\PaymentGateway;
use Illuminate\Support\Facades\Mail;

class OrdersController extends Controller
{
    /**
     * @var PaymentGateway
     */
    protected $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function store(Product $product)
    {
        $this->paymentGateway->charge($product->price, request('token'));

        Mail::to(request('email'))->send(new ProductEmail($product));

        return response()->json([], 201);
    }
}
