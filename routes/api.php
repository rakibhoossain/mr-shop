<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::get('/products', 'ProductController@collection')->name('api.product.collection');
// Route::get('/stocks', 'ProductController@stockCollection')->name('api.stock.collection');

// Route::get('/users', 'UserController@collection')->name('api.user.collection');
// Route::get('/admins', 'AdminController@collection')->name('api.admin.collection');
