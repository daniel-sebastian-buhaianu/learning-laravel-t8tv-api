<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\UserRole;
use App\Models\User;
use App\Models\RumbleChannel;
use App\Models\RumbleVideo;

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

Route::get('/user-role', [App\Http\Controllers\UserRoleController::class, 'index']);

Route::get('/user', [App\Http\Controllers\UserController::class, 'index']);

Route::get('/rumble-channel', [App\Http\Controllers\RumbleChannelController::class, 'index']);

Route::get('/rumble-video', [App\Http\Controllers\RumbleVideoController::class, 'index']);

Route::get('/video-category', [App\Http\Controllers\VideoCategoryController::class, 'index']);
Route::post('/video-category', [App\Http\Controllers\VideoCategoryController::class, 'store']);

// Route::post('/video-category', function() {
//     return VideoCategory::create([
//         'name' => 'Tate Specials'
//     ]);
// });

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
