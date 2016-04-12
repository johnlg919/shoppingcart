<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// regular routes
Route::group(['middleware' => ['web']], function () {

	// main page
	Route::get('/', 'ProductController@product_list'); 
	
	// product detail page
	Route::get('product/{id}', 'ProductController@product');
	Route::post('product/{id}', 'ProductController@product');

	// trigger removal of cart item
	Route::get('remove_product/{id}', 'ProductController@remove_product');
	Route::post('remove_product/{id}', 'ProductController@remove_product');

	// cart page
	Route::get('cart', 'CartController@show_cart');

	// checkout page
	Route::get('checkout', 'CheckoutController@checkout');
	Route::post('checkout', 'CheckoutController@checkout');

	// auth 
	Route::auth();	
});


// authenticated routes
Route::group(['middleware' => ['web', 'auth']], function () {

	// admin main page
	Route::get('admin/home', 'ProductController@list_product');
    
    // admin add product page
    Route::get('admin/add_product', 'ProductController@add_product');
    Route::post('admin/add_product', 'ProductController@add_product');
    
    // admin edit product page
    Route::get('admin/edit_product/{id}', 'ProductController@edit_product');
    Route::post('admin/edit_product/{id}', 'ProductController@edit_product');
    
    // admin delete product page
    Route::get('admin/delete_product/{id}', 'ProductController@delete_product');
    Route::post('admin/delete_product/{id}', 'ProductController@delete_product');
});


