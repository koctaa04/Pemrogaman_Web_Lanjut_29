<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\WelcomeController;

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


Route::get('/hello', [WelcomeController::class, 'hello']);
Route::resource('photos', PhotoController::class);

Route::resource('photos', PhotoController::class)->only([
    'index',
    'show'
]);
Route::resource('photos', PhotoController::class)->except([
    'create',
    'store',
    'update',
    'destroy'
]);

// Route::get('/greeting', function () {
//     return view('hello', ['name' => 'Andi']);
// });

Route::get('/greeting', [WelcomeController::class,'greeting']);


// BASIC ROUTE

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/hello', function () {
//     return 'Hello World';
// });

// Route::get('/', function () {
//     return 'Selamat Datang';
// });
// Route::get('/about', function () {
//     return 'Nim Saya : 2341720110';
// });

// // ROUTE PARAMETERS
// // Route::get('/user/{name}', function ($name) {
// //     return 'Nama saya ' . $name;
// // });


// Route::get('/posts/{post}/comments/{comment}', function 
// ($postId, $commentId) {
//     return 'Pos ke-'.$postId." Komentar ke-: ".$commentId;
// });

// Route::get('/articles/{id}', function ($id) {
//     return 'id saya ' . $id;
// });

// // OPTIONAL PARAMETERS
// // Route::get('/user/{name?}', function ($name=null) {
// //     return 'Nama saya '.$name;
// // });

// Route::get('/user/{name?}', function ($name='John') {
//     return 'Nama saya '.$name;
// });

// // Route Group dan Route Prefixes
// Route::middleware(['first', 'second'])->group(function () {
//     Route::get('/', function () {
//     // Uses first & second middleware...
//     });
//    Route::get('/user/profile', function () {
//     // Uses first & second middleware...
//     });
//    });
//    Route::domain('{account}.example.com')->group(function () {
//     Route::get('user/{id}', function ($account, $id) {
//     //
//     });
//    });
//    Route::middleware('auth')->group(function () {
//    Route::get('/user', [UserController::class, 'index']);
//    Route::get('/post', [PostController::class, 'index']);
//    Route::get('/event', [EventController::class, 'index']);
//    });


// // Route Prefix
// Route::prefix('admin')->group(function () {
//     Route::get('/user', [UserController::class, 'index']);
//     Route::get('/post', [PostController::class, 'index']);
//     Route::get('/event', [EventController::class, 'index']);
//     });

// // Redirects routes
// Route::redirect('/here', '/there')

// // View routes
// Route::view('/welcome', 'welcome');
// Route::view('/welcome', 'welcome', ['name' => 'Taylor']);