<?php

use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['auth', 'has_org'])->group(function () {
	Route::get('/', function () {
		return view('home', ['user' => Auth::user(), "owns_org" => request()->get('owns_org'), "in_org" => request()->get('in_org'), 'org_data' => request()->get('org_data'), 'announcements' => request()->get('announcements')]);
	})->middleware(['get_announcements'])->name('home');

	Route::resource('organisations', OrganisationController::class);

	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

	Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
	Route::get('/announcement/{id}', [AnnouncementController::class, 'show'])->name('announcements.show');

	Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');

	Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');

	Route::post('/comments', [CommentController::class, 'store'])->middleware(['auth'])->name('comments.store');
});



require __DIR__ . '/auth.php';
