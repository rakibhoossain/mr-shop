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

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/frontend', function () {
//     return view('frontend.index');
// });

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/shop', 'HomeController@shop')->name('shop');
Route::match(['get', 'post'], '/filter', 'HomeController@filter')->name('shop.filter');
Route::get('/product/{product}', 'HomeController@singleProduct')->name('product.single');


//Cart Routes
Route::get('/cart', ['middleware' => 'cart', 'uses' => 'CartController@index'] )->name('cart');
Route::match(['GET', 'POST'], '/add-to-cart/{product}', 'CartController@addToCart')->name('addToCart');
Route::get('/remove-from-cart/{code}', 'CartController@removeFromCart')->name('removeFromCart');
Route::post('/cart-update', 'CartController@cartUpdate')->name('cartUpdate');



//Customer route
Route::group(['prefix' => '/' ,'middleware' => 'auth:web'], function () {
    
    //Checkout Routes
    Route::group(['prefix' => '/' ,'middleware' => 'cart'], function () {
        Route::get('/checkout/{step?}', 'CartController@checkout' )->name('checkout');
        Route::post('/checkout/step1/store', 'CartController@checkoutStoreStep1')->name('checkout.store.step1');
        Route::post('/checkout/step2/store', 'CartController@checkoutStoreStep2')->name('checkout.store.step2');
        Route::post('/checkout/step3/store', 'CartController@checkoutStoreStep3')->name('checkout.store.step3');
    });
    Route::get('/checkout/step/final', 'CartController@checkoutFinal')->name('checkout.final');

    //Account routes
    Route::resource('/account', 'AccountController', ['only' => ['index', 'edit']]);
    Route::get('/account/{user}/orders', 'AccountController@orders')->name('orders');
    Route::get('/account/{user}/order/{order}/view', 'AccountController@order')->name('order.view');

});


//Dashboard Routes
Route::group(['prefix' => '/admin', 'middleware' => 'auth:admin'], function () {
    Route::get('/', 'DashboardController@index')->name('admin');
    //All product routes
    Route::prefix('/product')->group(function () {
	    Route::resource('/product', 'ProductController', ['as' => 'admin']);
        Route::post('/request/fields', 'ProductController@varientField')->name('admin.varient.field');




        Route::match(['GET', 'POST'], '/request/label-print', 'ProductController@labelPrint')->name('admin.barcode.print');
        Route::post('/request/label-print-preview', 'ProductController@labelPrintPreview')->name('admin.barcode.preview');
	    Route::resource('/barcode', 'BarcodeController', ['as' => 'admin.product']);


        Route::resource('/brand', 'BrandController', ['as' => 'admin.product']);
	    Route::resource('/productCategory', 'ProductCategoryController', ['as' => 'admin.product']);
        Route::resource('/productTag', 'ProductTagController', ['as' => 'admin.product']);
        Route::resource('/variation', 'VariationController', ['as' => 'admin.product']);


        Route::get('/stocks', 'ProductController@stocks')->name('admin.stocks');
    });   



    Route::resource('/order', 'OrderController', ['as' => 'admin']);

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



    Route::get('/collection/admins', 'AdminController@collection')->name('api.admin.collection');
    Route::get('/collection/products', 'ProductController@collection')->name('api.product.collection');
    Route::get('/collection/stocks', 'ProductController@stockCollection')->name('api.stock.collection');
    Route::get('/collection/orders', 'OrderController@collection')->name('api.order.collection');
    Route::get('/collection/users', 'UserController@collection')->name('api.user.collection'); 

});



//Admin login route
Route::group(['prefix'  =>  'admin'], function () {
    Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Admin\LoginController@login')->name('admin.login.post');
    Route::post('logout', 'Admin\LoginController@logout')->name('admin.logout');
});

