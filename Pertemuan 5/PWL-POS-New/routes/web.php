<?php

use Illuminate\Support\Facades\Route;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);      // Menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']);   // Menampilkan daftar user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']);   // Menampilkan halaman tambah user
    Route::post('/', [UserController::class, 'store']);   // Menyimpan data user baru
    Route::get('/{id}', [UserController::class, 'show']);   // Menampilkan halaman detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']);   // Menampilkan halaman ubah user
    Route::put('/{id}', [UserController::class, 'update']);   // Mengubah data user
    Route::delete('/{id}', [UserController::class, 'destroy']);   // Menghapus data user
});


// TUGAS PRAKTIKUM - JS 5 New
Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']);         // menampilkan halaman awal level
    Route::post('/list', [LevelController::class, 'list']);     // menampilkan data level dalam bentuk json untuk datatables
    Route::get('/create', [LevelController::class, 'create']);  // menampilkan halaman form tambah level
    Route::post('/', [LevelController::class, 'store']);        // menyimpan data level baru
    Route::get('/{id}', [LevelController::class, 'show']);      // menampilkan detail level
    Route::get('/{id}/edit', [LevelController::class, 'edit']); // menampilkan halaman form edit level
    Route::put('/{id}', [LevelController::class, 'update']);    // menyimpan perubahan data level
    Route::delete('/{id}', [LevelController::class, 'destroy']); // menghapus data level
});

Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']);         // menampilkan halaman awal kategori
    Route::post('/list', [KategoriController::class, 'list']);     // menampilkan data kategori dalam bentuk json untuk datatables
    Route::get('/create', [KategoriController::class, 'create']);  // menampilkan halaman form tambah kategori
    Route::post('/', [KategoriController::class, 'store']);        // menyimpan data kategori baru
    Route::get('/{id}', [KategoriController::class, 'show']);      // menampilkan detail kategori
    Route::get('/{id}/edit', [KategoriController::class, 'edit']); // menampilkan halaman form edit kategori
    Route::put('/{id}', [KategoriController::class, 'update']);    // menyimpan perubahan data kategori
    Route::delete('/{id}', [KategoriController::class, 'destroy']);// menghapus data kategori
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




// Route::get('/level', [LevelController::class, 'index']);

// Route::get('/kategori', [KategoriController::class, 'index']);

// Route::get('/user', [UserController::class, 'index']);
// Route::get('/user/tambah', [UserController::class, 'tambah']);
// Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
// Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
// Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
// Route::get('user/hapus/{id}', [UserController::class, 'hapus']);
// // Route::delete('/user/hapus/{id}',[UserController::class,'hapus']);