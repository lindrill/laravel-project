<?php

use Illuminate\Support\Facades\Route;
use App\Product;

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
	$products = Product::all();
    return view('welcome', compact('products'));
});

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard')->middleware('admin');
Route::resource('/users', 'UserController')->middleware('admin');
Route::resource('/products', 'ProductController')->middleware('admin');
Route::resource('/deliveries', 'DeliveryController')->middleware('admin');