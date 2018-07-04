<?php

namespace App\Http\Controllers;

use App\Product;

class ProductsController extends Controller
{
    public function show(Product $product)
    {
        return view('products.show', ['product' => $product]);
    }
}
