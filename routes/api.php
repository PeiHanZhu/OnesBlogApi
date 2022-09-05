<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LocationController;
use App\Models\Location;
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

Route::post('register', [AuthController::class, 'register'])->name('auth.register');
Route::post('verifyCode', [AuthController::class, 'verifyCode'])->name('auth.verifyCode');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::middleware(['auth:sanctum'])->group(function () {
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
Route::get('locations/{location}', [LocationController::class, 'show'])->name('locations.show');
Route::middleware('auth:sanctum')->group(function() {
    Route::post('locations', [LocationController::class, 'store'])->name('locations.store');
    Route::put('locations/{location}', [LocationController::class, 'update'])->name('locations.update');
    Route::delete('locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');
});

Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::middleware('auth:sanctum')->group(function() {
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

Route::scopeBindings()->group(function () {
    Route::get('posts/{post}/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::get('posts/{post}/comments/{comment}', [CommentController::class, 'show'])->name('comments.show');
    Route::middleware('auth:sanctum')->group(function() {
        Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
        Route::put('posts/{post}/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('posts/{post}/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    });
});
