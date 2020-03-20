<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/frontend', function () {
//     return view('frontend.index');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/product/{product}', 'ProductController@publicView')->name('product.publicView');


//Dashboard Routes
Route::group(['prefix' => '/admin', 'middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@index')->name('admin');
    //All product routes
    Route::prefix('/product')->group(function () {
	    Route::resource('/product', 'ProductController', ['as' => 'admin']);
	    Route::resource('/brand', 'BrandController', ['as' => 'admin.product']);
	    Route::resource('/size', 'SizeController', ['as' => 'admin.product']);
    });   

    Route::resource('/category', 'CategoryController', ['as' => 'admin']);
    Route::resource('/image', 'ImageController', ['as' => 'admin']); 

    Route::prefix('/post')->group(function () {
	    Route::resource('/post', 'PostController', ['as' => 'admin']);
    });

});
