<?php

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\UserController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home1', [App\Http\Controllers\HomeController::class, 'home'])->name('home1');
// Route::middleware(['auth', 'role:admin'])->group(function () {

Route::prefix('/admin')->name('admin.')->middleware(['role:admin', 'auth'])->group(function () {
    // Route::get('/admin', [OperatorController::class, 'index'])->name('operator');

    Route::get('/home', function () {
        return view('admin.index');
    })->name('home');
    Route::resource('user', UserController::class);
    Route::resource('category', CategoryController::class);
    //semua route dalam grup ini hanya bisa diakses oleh operator
});

// Route::middleware(['auth', 'role:user'])->group(function () {

Route::prefix('/user')->name('user.')->middleware(['role:user', 'auth'])->group(function () {
    // Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa');

    Route::get('/user', function () {
        return view('user.index');
    })->name('home');
    //semua route dalam grup ini hanya bisa diakses user
});
