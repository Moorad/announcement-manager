<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});

Route::post('/user/search', [UserController::class, 'search'])->name('user.search');
Route::post('/user/update_member', [UserController::class, 'update_member'])->name('user.update_member');
Route::post('/user/update_announcer', [UserController::class, 'update_announcer'])->name('user.update_announcer');

Route::post('/announcements/image/{id}', [AnnouncementController::class, 'image'])->name('announcements.image');
Route::post('/announcements/update_vote', [AnnouncementController::class, 'update_vote'])->name('announcements.vote');
