<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController;
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

Route::get('/',[ProductController::class, "viewAll"])->name('home');
Route::get('/detail/{id}', [ProductController::class, "detail"]);

Route::get('/product/create', [ProductController::class,"createForm"])->middleware('admin')->name('create');
Route::post('/product/create', [ProductController::class, "postForm"])->middleware('admin');

Route::get('/product/update/{id}', [ProductController::class,"updateForm"])->middleware('admin');
Route::put('/product/update/{id}', [ProductController::class, "postUpdateForm"])->middleware('admin');


Route::get('/add-to-cart/{id}', [ProductController::class, "addToCart"]);
Route::get('/cart',[ProductController::class, "viewCart"]);


Route::get('/category/{id}',[CategoriesController::class, "getProductByCategory"]);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
