<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])
    ->name('products.show');

Route::get('/cart',[CartController::class,'index'])->name('cart');
Route::post('/cart',[CartController::class,'add'])->name('cart.store');
Route::patch('/cart/{id}',[CartController::class,'update'])->name('cart.update');
Route::delete('/cart/{id}',[CartController::class,'remove'])->name('cart.remove');

Route::middleware(['auth','role:user'])->group(function(){
    Route::get('/dashboard',function(){
        return view('dashboard');
    });
});
Route::middleware(['auth','role:admin'])->group(function(){

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
