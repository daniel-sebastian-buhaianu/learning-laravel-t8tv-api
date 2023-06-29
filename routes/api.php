<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RumbleChannelController;
use App\Http\Controllers\RumbleVideoController;
use App\Http\Controllers\VideoCategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::get('/user-role', [UserRoleController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);
Route::get('/rumble-channel', [RumbleChannelController::class, 'index']);
Route::get('/rumble-video', [RumbleVideoController::class, 'index']);

Route::controller(VideoCategoryController::class)->group(function () {
	Route::get('/video-category', 'index');
	Route::get('/video-category/{id}', 'show');
	Route::get('/video-category/search/{name}', 'search');
});

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])->group(function () {

	Route::controller(VideoCategoryController::class)->group(function () {
		Route::post('/video-category', 'store');
		Route::put('/video-category/{id}', 'update');
		Route::delete('/video-category/{id}', 'destroy');
	});

	Route::post('/logout', [AuthController::class, 'logout']);

});