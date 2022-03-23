<?php

use App\Http\Controllers\APIController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', [APIController::class, 'test'])->middleware('auth:sanctum');
Route::post('/login', [APIController::class, "login"]);
Route::get('/products', [APIController::class, "products"]);
Route::get('/product/{id}', [APIController::class, "product"]);


Route::post('/product/create', [APIController::class, "createProduct"]);
