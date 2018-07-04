<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products/{product}', 'ProductsController@show');

Route::post('/products/{product}/orders', 'OrdersController@store');
