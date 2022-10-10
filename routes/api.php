<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\LocationScoreController;
use App\Http\Controllers\Api\LocationServiceHourController;
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

Route::scopeBindings()->group(function () {
    Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
    Route::get('locations/{location}', [LocationController::class, 'show'])->name('locations.show');
    Route::get('location-scores', [LocationScoreController::class, 'index'])->name('location-scores.index');
    Route::get('locations/{location}/location-service-hours', [LocationServiceHourController::class, 'index'])->name('location-service-hours.index');
    Route::get('locations/{location}/location-service-hours/{location_service_hour}', [LocationServiceHourController::class, 'show'])->name('location-service-hours.show');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('locations', [LocationController::class, 'store'])->name('locations.store');
        Route::put('locations/{location}', [LocationController::class, 'update'])->name('locations.update');
        Route::delete('locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');

        Route::post('locations/{location}/location-scores', [LocationScoreController::class, 'store'])->name('location-scores.store');
        Route::post('locations/{location}/location-service-hours', [LocationServiceHourController::class, 'store'])->name('location-service-hours.store');
        Route::put('locations/{location}/location-service-hours/{location_service_hour}', [LocationServiceHourController::class, 'update'])->name('location-service-hours.update');
        Route::delete('locations/{location}/location-service-hours/{location_service_hour}', [LocationServiceHourController::class, 'destroy'])->name('location-service-hours.destroy');
    });
});

Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

Route::scopeBindings()->group(function () {
    Route::get('posts/{post}/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::get('posts/{post}/comments/{comment}', [CommentController::class, 'show'])->name('comments.show');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
        Route::put('posts/{post}/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('posts/{post}/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    });
});

Route::get('cities', [CityController::class, 'index'])->name('cities.index');
Route::get('cities/{city}', [CityController::class, 'show'])->name('cities.show');
