<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;

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

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/level', [LevelController::class, 'index'])->name('level.index');
Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
Route::get('/user', [UserController::class, 'index'])->name('user.index');
