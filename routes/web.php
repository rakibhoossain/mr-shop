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
Route::get('/shop', 'HomeController@shop')->name('shop');
Route::match(['get', 'post'], '/filter', 'HomeController@filter')->name('shop.filter');
Route::get('/product/{product}', 'HomeController@singleProduct')->name('product.single');

Route::get('/cart', ['middleware' => 'cart', 'uses' => 'CartController@index'] )->name('cart');

Route::match(['GET', 'POST'], '/add-to-cart/{product}', 'CartController@addToCart')->name('addToCart');
Route::get('/remove-from-cart/{code}', 'CartController@removeFromCart')->name('removeFromCart');
Route::post('/cart-update', 'CartController@cartUpdate')->name('cartUpdate');


//Dashboard Routes
Route::group(['prefix' => '/admin', 'middleware' => 'auth:admin'], function () {
    Route::get('/', 'DashboardController@index')->name('admin');
    //All product routes
    Route::prefix('/product')->group(function () {
	    Route::resource('/product', 'ProductController', ['as' => 'admin']);
        Route::post('/request/fields', 'ProductController@varientField')->name('admin.varient.field');
        
	    Route::resource('/brand', 'BrandController', ['as' => 'admin.product']);
	    Route::resource('/category', 'ProductCategoryController', ['as' => 'admin.product']);
        Route::get('/stocks', 'ProductController@stocks')->name('admin.stocks');
    });   

    Route::resource('/category', 'CategoryController', ['as' => 'admin']);
    Route::resource('/image', 'ImageController', ['as' => 'admin']);

    Route::prefix('/post')->group(function () {
	    Route::resource('/post', 'PostController', ['as' => 'admin']);
    });


    Route::resource('/settings', 'SettingController', ['as' => 'admin', 'only' => ['index', 'store']]);

    //User Management
    Route::resource('role','RoleController', ['as' => 'admin']);
    Route::resource('admin','AdminController');
    Route::resource('user','UserController');    

});



//Admin login route
Route::group(['prefix'  =>  'admin'], function () {
    Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Admin\LoginController@login')->name('admin.login.post');
    Route::post('logout', 'Admin\LoginController@logout')->name('admin.logout');
});
