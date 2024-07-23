<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'login'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'register'])->name('register.post');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [AuthController::class, 'dashboard']);
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    // Posts Routes
    Route::get('posts', [PostController::class, 'posts'])->name('posts');
    Route::get('/posts/create', [PostController::class, 'createPost'])->name('post.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/edit/{id}', [PostController::class, 'editPost'])->name('post.edit');
    Route::patch('/posts/update/{id}', [PostController::class, 'updatePost'])->name('post.update');
    Route::delete('/posts/delete/{id}', [PostController::class, 'deletePost'])->name('post.delete');
});
