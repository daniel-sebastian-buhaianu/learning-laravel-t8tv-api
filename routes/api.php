<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\UserRole;
use App\Models\User;
use App\Models\RumbleChannel;
use App\Models\RumbleVideo;
use App\Models\VideoCategory;

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

Route::get('/user-role', function() {
    return UserRole::all();
});

Route::get('/user', function() {
    return User::all();
});

Route::get('/rumble-channel', function() {
    return RumbleChannel::all();
});

Route::get('/rumble-video', function() {
    return RumbleVideo::all();
});

Route::get('/video-category', function() {
    return VideoCategory::all();
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
