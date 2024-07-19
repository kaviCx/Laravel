<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'login'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'register'])->name('register.post'); 
Route::get('dashboard', [AuthController::class, 'dashboard']); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
