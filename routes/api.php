<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

Route::post('register', [ApiController::class, 'register'])->name('register');
Route::post('login', [ApiController::class, 'login'])->name('login');

Route::group([
    'middleware' => ['auth:sanctum']
], function(){
    Route::get('/profile', [ApiController::class, 'profile']);

    Route::get('/logout', [ApiController::class, 'logout']);
});

// Route::get('/profile', [ApiController::class, 'profile'])->middleware(['auth:sanctum', 'abilities:check-status,place-orders']);



