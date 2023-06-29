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

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])->group(function () {

	Route::post('/logout', [AuthController::class, 'logout']);

	Route::get('/user', [UserController::class, 'index']);
	Route::get('/rumble-channel', [RumbleChannelController::class, 'index']);
	Route::get('/rumble-video', [RumbleVideoController::class, 'index']);

	Route::controller(VideoCategoryController::class)->group(function () {
		Route::get('/video-category', 'index');
		Route::post('/video-category', 'store')->middleware('can:create,App\Models\VideoCategory');
		Route::get('/video-category/{id}', 'show');
		Route::put('/video-category/{id}', 'update')->middleware('can:update,App\Models\VideoCategory');
		Route::delete('/video-category/{id}', 'destroy')->middleware('can:delete,App\Models\VideoCategory');
		Route::get('/video-category/search/{name}', 'search');
	});

	Route::controller(UserRoleController::class)->group(function () {
		Route::get('/user-role', 'index');
		Route::post('/user-role', 'store')->middleware('can:create,App\Models\UserRole');
		Route::get('/user-role/{id}', 'show');
		Route::put('/user-role/{id}', 'update')->middleware('can:update,App\Models\UserRole');
		Route::delete('/user-role/{id}', 'destroy')->middleware('can:delete,App\Models\UserRole');
		Route::get('/user-role/search/{name}', 'search');
	});
});