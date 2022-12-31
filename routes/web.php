<?php

use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\AnnouncementController;
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

Route::get('/', function () {
	return view('home', ['name' => Auth::user()->name, 'role' => Auth::user()->role, 'user_id' => Auth::user()->id, "owns_org" => request()->get('owns_org'), "in_org" => request()->get('in_org'), 'org_data' => request()->get('org_data'), 'announcements' => request()->get('announcements')]);
})->middleware(['auth', 'verified', 'has_org', 'get_announcements'])->name('home');

Route::middleware(['auth', 'has_org'])->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

	Route::post('/organisations', [OrganisationController::class, 'store'])->middleware(['auth'])->name('organisations.store');
	Route::get('/organisations', [OrganisationController::class, 'index'])->name('organisations.index');
	Route::get('/organisations/create', [OrganisationController::class, 'create'])->middleware(['has_org'])->name('organisations.create');
	Route::get('/organisations/users', [OrganisationController::class, 'users'])->middleware(['has_org'])->name('organisations.users');

	Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
	Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
});



require __DIR__ . '/auth.php';
