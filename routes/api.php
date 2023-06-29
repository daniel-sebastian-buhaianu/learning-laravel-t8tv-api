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

	Route::get('/rumble-channel', [RumbleChannelController::class, 'index']);
	Route::get('/rumble-video', [RumbleVideoController::class, 'index']);

	// User Role
	Route::controller(UserRoleController::class)->group(function () {
		Route::get('/user-role', 'index');
		Route::post('/user-role', 'store')->middleware('can:create,App\Models\UserRole');
		Route::get('/user-role/{id}', 'show');
		Route::put('/user-role/{id}', 'update')->middleware('can:update,App\Models\UserRole');
		Route::delete('/user-role/{id}', 'destroy')->middleware('can:delete,App\Models\UserRole');
		Route::get('/user-role/search/{name}', 'search');
	});

	// User
	Route::controller(UserController::class)->group(function () {
		Route::get('/user', 'index')->middleware('can:viewAny,App\Models\User');
		Route::get('/user/{id}', 'show')->middleware('can:view,App\Models\User,id');
		Route::put('/user/{id}', 'update')->middleware('can:update,App\Models\User,id');
		Route::delete('/user/{id}', 'destroy')->middleware('can:delete,App\Models\User');
		Route::get('/user/search/{email}', 'search')->middleware('can:viewAny,App\Models\User');
	});

	// Rumble Channel
	Route::controller(RumbleChannelController::class)->group(function () {
		Route::get('/rumble-channel', 'index');
		Route::post('/rumble-channel', 'store')->middleware('can:create,App\Models\RumbleChannel');
		Route::get('/rumble-channel/{id}', 'show');
		// Route::put('/rumble-channel/{id}', 'update')->middleware('can:update,App\Models\RumbleChannel');
		Route::delete('/rumble-channel/{id}', 'destroy')->middleware('can:delete,App\Models\RumbleChannel');
		Route::get('/rumble-channel/search/{title}', 'search');
	});

	// Video Category
	Route::controller(VideoCategoryController::class)->group(function () {
		Route::get('/video-category', 'index');
		Route::post('/video-category', 'store')->middleware('can:create,App\Models\VideoCategory');
		Route::get('/video-category/{id}', 'show');
		Route::put('/video-category/{id}', 'update')->middleware('can:update,App\Models\VideoCategory');
		Route::delete('/video-category/{id}', 'destroy')->middleware('can:delete,App\Models\VideoCategory');
		Route::get('/video-category/search/{name}', 'search');
	});

	// Rumble Video
	Route::controller(RumbleVideoController::class)->group(function () {
	// 	Route::get('/rumble-video', 'index');
	// 	Route::post('/rumble-video', 'store')->middleware('can:create,App\Models\RumbleVideo');
	// 	Route::get('/rumble-video/{id}', 'show');
	// 	Route::put('/rumble-video/{id}', 'update')->middleware('can:update,App\Models\RumbleVideo');
	// 	Route::delete('/rumble-video/{id}', 'destroy')->middleware('can:delete,App\Models\RumbleVideo');
	// 	Route::get('/rumble-video/search/{name}', 'search');
	});
});