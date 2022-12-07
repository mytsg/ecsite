<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\LikeController;

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

Route::get('/',[ProductController::class,'index']);

Route::get('/login',function(){
    return view('use.login');
})->name('login');

Route::get('/register',function(){
    return view('user.register');
})->name('register');

Route::get('/dashboard', function () {
    return view('user.dashboard');
})->middleware(['auth:users'])->name('dashboard');

Route::resource('products', ProductController::class)
->middleware('auth:users');

Route::get('/profile/{userId}',[UserController::class,'profile'])
->name('profile');

Route::prefix('like')->
    middleware('auth:users')->group(function(){
        Route::post('add',[LikeController::class,'add'])->name('like.add');
        Route::get('/',[LikeController::class,'index'])->name('like.index');
        Route::get('/likes/{id}',[LikeController::class,'like'])->name('like.likes');
        Route::get('/unlikes/{id}',[LikeController::class,'unlike'])->name('like.unlikes');
        Route::post('/delete/{id}',[LikeController::class,'delete'])->name('like.delete');
    });

Route::get('products/checkout/{id}',[ProductController::class,'checkout'])->name('products.checkout')
        ->middleware('auth:users');

Route::get('products/success/{id}',[ProductController::class,'success'])->name('products.success')
        ->middleware('auth:users');

require __DIR__.'/auth.php';
