<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DataCabangController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DetailTransactionController;
use App\Http\Controllers\TransactionController;

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
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home1', [App\Http\Controllers\HomeController::class, 'home'])->name('home1');
// Route::middleware(['auth', 'role:admin'])->group(function () {

Route::resource('transaction', TransactionController::class);
Route::get('/transaction/{transaction_id}/detailtransaction', [DetailTransactionController::class, 'index'])->name('detailtransaction.index');
Route::get('/transaction/{transaction_id}/detailtransaction/create', [DetailTransactionController::class, 'create'])->name('detailtransaction.create');
Route::post('/transaction/{transaction_id}/detailtransaction', [DetailTransactionController::class, 'store'])->name('detailtransaction.store');
Route::get('/transaction/{transaction_id}/detailtransaction/{detailtransaction_id}/show', [DetailTransactionController::class, 'show'])->name('detailtransaction.show');
Route::post('/transaction/{transaction_id}/detailtransaction/{detailtransaction_id}/accept', [DetailTransactionController::class, 'accept'])->name('detailtransaction.accept');
Route::post('/transaction/{transaction_id}/detailtransaction/{detailtransaction_id}/send', [DetailTransactionController::class, 'send'])->name('detailtransaction.send');

Route::prefix('/admin')->name('admin.')->middleware(['role:admin', 'auth'])->group(function () {
    // Route::get('/admin', [OperatorController::class, 'index'])->name('operator');

    Route::get('/home', function () {
        return redirect()->route('admin.category.index');
    })->name('home');
    Route::resource('user', UserController::class);
    Route::resource('category', CategoryController::class);
    Route::get('/cabang', [DataCabangController::class, 'index'])->name('cabang.index');
    Route::get('/cabang/{id}/show', [DataCabangController::class, 'show'])->name('cabang.show');

    Route::get('/cabang/{cabang_id}/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/cabang/{cabang_id}/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/cabang/{cabang_id}/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/cabang/{cabang_id}/product/{product_id}', [ProductController::class, 'show'])->name('product.show');
    Route::get('/cabang/{cabang_id}/product/{product_id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/cabang/{cabang_id}/product/{product_id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/cabang/{cabang_id}/product/{product_id}', [ProductController::class, 'destroy'])->name('product.destroy');
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
