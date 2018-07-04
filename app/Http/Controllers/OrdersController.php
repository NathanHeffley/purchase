<?php

namespace App\Http\Controllers;

use App\Exceptions\PaymentFailedException;
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
        try {
            $this->paymentGateway->charge($product->price, request('token'));
        } catch (PaymentFailedException $e) {
            return response()->json([], 422);
        }

        Mail::to(request('email'))->send(new ProductEmail($product));

        return response()->json([], 201);
    }
}
