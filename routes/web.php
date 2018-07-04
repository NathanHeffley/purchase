<?php

Route::get('/', function () {
    return view('welcome');
});

Route::post('/products/{product}/orders', 'OrdersController@store');
