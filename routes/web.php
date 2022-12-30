<?php

use App\Http\Controllers\OrganisationController;
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
	return view('home', ['name' => Auth::user()->name, 'role' => Auth::user()->role, "has_org" => request()->get('has_org')]);
})->middleware(['auth', 'verified', 'has_org'])->name('home');

Route::middleware('auth')->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

	Route::post('/organisations', [OrganisationController::class, 'store'])->middleware(['auth'])->name('organisations.store');
	Route::get('/organisations', [OrganisationController::class, 'index'])->name('organisations.index');
	Route::get('/organisations/create', [OrganisationController::class, 'create'])->middleware(['has_org'])->name('organisations.create');
	Route::get('/organisations/users', [OrganisationController::class, 'users'])->middleware(['has_org'])->name('organisations.users');
});



require __DIR__ . '/auth.php';
