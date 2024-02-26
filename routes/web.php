<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', 'App\Http\Controllers\AuthController@loginPage')->name('loginPage');
Route::get('/register', 'App\Http\Controllers\AuthController@registerPage')->name('registerPage');
Route::post('login', 'App\Http\Controllers\AuthController@login')->name('login');
Route::post('register', 'App\Http\Controllers\AuthController@register')->name('register');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'App\Http\Controllers\CategoryController@index')->name('home');
    Route::middleware(['admin'])->group(function () {
        Route::get('/product', 'App\Http\Controllers\CategoryController@categoryForm')->name('product');
        Route::post('category', 'App\Http\Controllers\CategoryController@store')->name('product.add');
        Route::get('category/{id}', 'App\Http\Controllers\CategoryController@show')->name('product.show');
        Route::post('category/{id}', 'App\Http\Controllers\CategoryController@update')->name('product.edit');
        Route::get('category/delete/{id}', 'App\Http\Controllers\CategoryController@deleteCategoryItem')->name('product.delete');
        Route::get('/users', 'App\Http\Controllers\UserController@index')->name('userList');
    });

    Route::middleware(['user'])->group(function () {
        Route::get('product/data', 'App\Http\Controllers\CategoryController@getItem')->name('product.data');
        Route::post('add-to-cart', 'App\Http\Controllers\UserCartController@store')->name('addToCart');
        Route::get('/user/cart', 'App\Http\Controllers\UserCartController@index')->name('user.cart');
    });

    Route::get('/profile', 'App\Http\Controllers\UserController@show')->name('profile');
    Route::get('logout', 'App\Http\Controllers\AuthController@logout')->name('logout');
});
