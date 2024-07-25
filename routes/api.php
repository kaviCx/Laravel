<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::post('register', [ApiController::class, 'register']);
Route::post('login', [ApiController::class, 'login']);

Route::group([
    'middleware' => ['auth:api']
], function(){
    Route::get('/logout', [ApiController::class, 'logout']);
    Route::get('/posts', [ApiController::class, 'fetchPosts']);
    Route::get('/get-posts', [ApiController::class, 'getPosts']);
    Route::get('/comments', [ApiController::class, 'getComments']);
});

