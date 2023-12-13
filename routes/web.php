<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController;


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
// Route::get('/index', [CategoriesController::class, 'index'])->name('index');

Route::resource('Categories', CategoriesController::class);



Route::resource('Products', ProductController::class);



Route::post('/remove-product-image', [ProductController::class, 'removeProductImage'])->name('removeProductImage');
