<?php

use Illuminate\Support\Facades\Route;
use App\Product;
use App\Delivery;

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
	$deliveries = Delivery::all();
	$products = Product::all();
	$data = app('App\Http\Controllers\HomeController')->get_stocks($deliveries, $products);
    return view('welcome', compact('data'));
});

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard')->middleware('admin');
Route::get('/stocks/{id}/edit', 'HomeController@edit')->middleware('admin');
Route::get('/stock/{id}', 'HomeController@show')->middleware('admin');
Route::patch('/stocks/{id}', 'HomeController@update')->middleware('admin');
Route::get('/search_delivery_product', 'HomeController@search_delivery_product')->middleware('admin');
Route::get('/users', 'UserController@index')->middleware('admin');
Route::get('/users/{id}', 'UserController@show')->middleware('auth');
Route::get('/users/{id}/edit', 'UserController@edit')->middleware('admin');
Route::patch('/users/{id}', 'UserController@update')->middleware('admin');
Route::delete('/users/{id}', 'UserController@destroy')->middleware('admin');
Route::resource('/products', 'ProductController')->middleware('admin');
Route::resource('/deliveries', 'DeliveryController')->middleware('admin');
Route::get('/change-password/{id}/edit', 'UserController@change_password')->middleware('admin');
Route::patch('/change-password/{id}/', 'UserController@update_password')->middleware('admin');
Route::put('/update_account/{id}/', 'UserController@update_account')->middleware('auth');
Route::get('/search_product', 'ProductController@search_product');
Route::resource('/cart', 'CartController')->middleware('auth');
Route::put('/update_cart', 'CartController@update_cart');
Route::resource('/sales', 'SalesController')->middleware('auth');
Route::get('/purchase', 'SalesController@purchase')->middleware('auth');
Route::get('/search_sales', 'SalesController@search_sales')->middleware('admin');
Route::get('/sales_pdf/{keyword}/{start_date}/{end_date}','SalesController@export_pdf')->middleware('admin');