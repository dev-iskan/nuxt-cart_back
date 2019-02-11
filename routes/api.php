<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::resource('/categories', 'Categories\CategoryController');
Route::resource('/products', 'Products\ProductController');

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::post('/register', 'RegisterController@action');
    Route::post('/login', 'LoginController@action');
    Route::get('/me', 'MeController@action');
});

Route::resource('/cart', 'Cart\CartController', [
        'parameters' => [
            'cart' => 'productVariation'
        ]
    ]);
