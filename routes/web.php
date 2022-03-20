<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KategoriController;

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

Route::get("/", [ProductController::class, 'index']);

Route::prefix('dashboard')->group(function () {
    Route::get("login", [AdminController::class, 'index']);
    Route::post("login/check", [AdminController::class, 'login']);
    Route::get("/", [AdminController::class, 'dashboard']);
});
Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'listProduct']);
    Route::get("list",[ProductController::class, 'dataProduk']);
    Route::get("create",[ProductController::class, 'dataProdukView']);
    Route::post("create",[ProductController::class, 'create']);
});

Route::prefix('kategori')->group(function () {
    Route::get('/', [KategoriController::class, 'listKategori']);
});
