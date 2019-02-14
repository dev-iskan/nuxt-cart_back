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
    // in the bellow routes we invoke magic method which will call only one method inside these controllers
    Route::post('/login', 'LoginController');
    Route::get('/me', 'MeController');
});

Route::resource('/cart', 'Cart\CartController', [
        'parameters' => [
            'cart' => 'productVariation'
        ]
    ]);
