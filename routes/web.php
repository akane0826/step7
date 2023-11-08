<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/products', 'App\Http\Controllers\ProductController@index')->name('products.index');



Route::get('/products/create', 'App\Http\Controllers\ProductController@create')->name('product.create');
Route::post('/products/store/', 'App\Http\Controllers\ProductController@store')->name('product.store');

Route::get('/products/show/{product}', 'App\Http\Controllers\ProductController@show')->name('product.show');

Route::get('/products/edit/{id}','App\Http\Controllers\ProductController@edit')->name('product.edit');
Route::put('/products/edit/{id}','App\Http\Controllers\ProductController@update')->name('product.update');

Route::delete('/products/{product}','App\Http\Controllers\ProductController@destroy')->name('product.destroy');