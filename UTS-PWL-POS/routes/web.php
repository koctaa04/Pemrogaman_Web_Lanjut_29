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

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);                          // Menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']);                      // Menampilkan daftar user dalam bentuk json untuk datatables
    Route::get('/create_ajax', [UserController::class, 'create_ajax']);         // Menampilkan halaman tambah user dengan Ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']);                // menyimpan data user dengan Ajax
    Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);        // menampilkan detail data user dengan Ajax
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);        // menampilkan halaman form edit user Ajax
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);    // menyimpan perubahan data user Ajax
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);   // Untuk tampilkan form confirm delete user Ajax
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data user Ajax
});

Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']);                          // Menampilkan halaman awal level
    Route::post('/list', [LevelController::class, 'list']);                      // Menampilkan daftar level dalam bentuk json untuk datatables
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']);         // Menampilkan halaman tambah level dengan Ajax
    Route::post('/ajax', [LevelController::class, 'store_ajax']);                // menyimpan data level dengan Ajax
    Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']);        // menampilkan detail data level dengan Ajax
    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);        // menampilkan halaman form edit level Ajax
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);    // menyimpan perubahan data level Ajax
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);   // Untuk tampilkan form confirm delete level Ajax
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // Untuk hapus data level Ajax
    
});

Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']);                          // Menampilkan halaman awal Kategori
    Route::post('/list', [KategoriController::class, 'list']);                      // Menampilkan daftar Kategori dalam bentuk json untuk datatables
    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);         // Menampilkan halaman tambah Kategori dengan Ajax
    Route::post('/ajax', [KategoriController::class, 'store_ajax']);                // menyimpan data Kategori dengan Ajax
    Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']);        // menampilkan detail data Kategori dengan Ajax
    Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);        // menampilkan halaman form edit Kategori Ajax
    Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);    // menyimpan perubahan data Kategori Ajax
    Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);   // Untuk tampilkan form confirm delete Kategori Ajax
    Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // Untuk hapus data Kategori Ajax
});

Route::group(['prefix' => 'supplier'], function () {
    Route::get('/', [SupplierController::class, 'index']);         // Menampilkan halaman awal supplier
    Route::post('/list', [SupplierController::class, 'list']);     // Menampilkan data supplier dalam bentuk JSON untuk datatables
    Route::get('/create', [SupplierController::class, 'create']);  // Menampilkan halaman form tambah supplier
    Route::post('/', [SupplierController::class, 'store']);        // Menyimpan data supplier baru
    Route::get('/{id}', [SupplierController::class, 'show']);      // Menampilkan detail supplier
    Route::get('/{id}/edit', [SupplierController::class, 'edit']); // Menampilkan halaman form edit supplier
    Route::put('/{id}', [SupplierController::class, 'update']);    // Menyimpan perubahan data supplier
    Route::delete('/{id}', [SupplierController::class, 'destroy']); // Menghapus data supplier
});

Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index']);         // menampilkan halaman awal barang
    Route::post('/list', [BarangController::class, 'list']);     // menampilkan data barang dalam bentuk json untuk datatables
    Route::get('/create', [BarangController::class, 'create']);  // menampilkan halaman form tambah barang
    Route::post('/', [BarangController::class, 'store']);        // menyimpan data barang baru
    Route::get('/{id}', [BarangController::class, 'show']);      // menampilkan detail barang
    Route::get('/{id}/edit', [BarangController::class, 'edit']); // menampilkan halaman form edit barang
    Route::put('/{id}', [BarangController::class, 'update']);    // menyimpan perubahan data barang
    Route::delete('/{id}', [BarangController::class, 'destroy']); // menghapus data barang
});