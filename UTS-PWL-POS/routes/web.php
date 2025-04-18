<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenjualanController;
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
    Route::get('/', [SupplierController::class, 'index']);                          // Menampilkan halaman awal Supplier
    Route::post('/list', [SupplierController::class, 'list']);                      // Menampilkan daftar Supplier dalam bentuk json untuk datatables
    Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);         // Menampilkan halaman tambah Supplier dengan Ajax
    Route::post('/ajax', [SupplierController::class, 'store_ajax']);                // menyimpan data Supplier dengan Ajax
    Route::get('/{id}/show_ajax', [SupplierController::class, 'show_ajax']);        // menampilkan detail data Supplier dengan Ajax
    Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);        // menampilkan halaman form edit Supplier Ajax
    Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);    // menyimpan perubahan data Supplier Ajax
    Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);   // Untuk tampilkan form confirm delete Supplier Ajax
    Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // Untuk hapus data Supplier Ajax
});

Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index']);                          // Menampilkan halaman awal barang
    Route::post('/list', [BarangController::class, 'list']);                      // Menampilkan daftar barang dalam bentuk json untuk datatables
    Route::get('/create_ajax', [BarangController::class, 'create_ajax']);         // Menampilkan halaman tambah barang dengan Ajax
    Route::post('/ajax', [BarangController::class, 'store_ajax']);                // menyimpan data barang dengan Ajax
    Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']);        // menampilkan detail data barang dengan Ajax
    Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);        // menampilkan halaman form edit barang Ajax
    Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);    // menyimpan perubahan data barang Ajax
    Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);   // Untuk tampilkan form confirm delete barang Ajax
    Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // Untuk hapus data barang Ajax
});

Route::group(['prefix' => 'stok'], function () {
    Route::get('/', [StokController::class, 'index']);                          // Menampilkan halaman awal stok
    Route::post('/list', [StokController::class, 'list']);                      // Menampilkan daftar stok dalam bentuk json untuk datatables
    Route::get('/create_ajax', [StokController::class, 'create_ajax']);         // Menampilkan halaman tambah stok dengan Ajax
    Route::post('/ajax', [StokController::class, 'store_ajax']);                // menyimpan data stok dengan Ajax
    Route::get('/{id}/show_ajax', [StokController::class, 'show_ajax']);        // menampilkan detail data stok dengan Ajax
    Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']);        // menampilkan halaman form edit stok Ajax
    Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']);    // menyimpan perubahan data stok Ajax
    Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']);   // Untuk tampilkan form confirm delete stok Ajax
    Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']); // Untuk hapus data stok Ajax
});


Route::group(['prefix' => 'penjualan'], function () {
    Route::get('/', [PenjualanController::class, 'index']);                          // Menampilkan halaman awal penjualan
    Route::post('/list', [PenjualanController::class, 'list']);                      // Menampilkan daftar penjualan dalam bentuk json untuk datatables
    Route::get('/create_ajax', [PenjualanController::class, 'create_ajax']);         // Menampilkan halaman tambah penjualan dengan Ajax
    Route::post('/ajax', [PenjualanController::class, 'store_ajax']);                // menyimpan data penjualan dengan Ajax
    Route::get('/{id}/show_ajax', [PenjualanController::class, 'show_ajax']);        // menampilkan detail data penjualan dengan Ajax
    // Route::get('/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']);        // menampilkan halaman form edit penjualan Ajax
    // Route::put('/{id}/update_ajax', [PenjualanController::class, 'update_ajax']);    // menyimpan perubahan data penjualan Ajax
    Route::get('/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']);   // Untuk tampilkan form confirm delete penjualan Ajax
    Route::delete('/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']); // Untuk hapus data penjualan Ajax
});