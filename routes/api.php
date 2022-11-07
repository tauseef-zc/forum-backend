<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Forum\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
 |--------------------------------------------------------------------------
 | API Routes
 |--------------------------------------------------------------------------
 |
 | Here is where you can register API routes for your application. These
 | routes are loaded by the RouteServiceProvider within a group which
 | is assigned the "api" middleware group. Enjoy building your API!
 |
 */

/* Auth routes */
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () { 
    /* Admin API */
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('posts', [AdminPostController::class, 'index']);
        Route::post('posts/submit', [AdminPostController::class, 'submit']);
        Route::put('posts/{id}/status/update', [AdminPostController::class, 'updateStatus']);
    });

    /* Forum API */
    Route::get('approved-posts', [PostController::class, 'index']);

    /* User API */
    Route::prefix('dashboard')->group(function () {
        Route::get('posts', [PostController::class, 'posts']);
        Route::post('posts/submit', [PostController::class, 'submit']);
        Route::delete('posts/{id}', [PostController::class, 'delete']);
    });
});

Route::middleware('auth:sanctum')->get(
    '/user', function (Request $request) {
        return $request->user();
    }
);