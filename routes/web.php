<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('Dashboard.dashboard');
// });

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


Route::prefix('user')->name('user.')->middleware('isAdmin')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index'); 
    Route::get('/tambah-data', [UserController::class, 'create'])->name('create'); 
    Route::post('/', [UserController::class, 'store'])->name('store'); 
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit'); 
    Route::put('/{user}', [UserController::class, 'update'])->name('update'); 
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy'); 
});

Route::prefix('produk')->name('produk.')->group(function () {
    Route::get('/', [ProdukController::class, 'index'])->name('index'); 
    Route::get('/tambah-data', [ProdukController::class, 'create'])->name('create'); 
    Route::post('/', [ProdukController::class, 'store'])->name('store'); 
    Route::get('/{produk}/edit', [ProdukController::class, 'edit'])->name('edit'); 
    Route::put('/{produk}', [ProdukController::class, 'update'])->name('update'); 
    Route::post('/update-stock/{id}', [ProdukController::class, 'updateStock'])->name('updateStock'); 
    Route::delete('/{produk}', [ProdukController::class, 'destroy'])->name('destroy'); 
});

Route::prefix('pembelian')->name('pembelian.')->group(function () {
    Route::get('/export-pembelian', [PembelianController::class, 'exportExcel'])->name('exportExcel');
    Route::get('/', [PembelianController::class, 'index'])->name('index'); 
    Route::get('/create', [PembelianController::class, 'create'])->name('create'); 
    Route::post('/', [PembelianController::class, 'store'])->name('store'); 
    Route::get('/pembelian/{id}/invoice', [PembelianController::class, 'showInvoice'])->name('invoice');
    Route::delete('/{pembelian}', [PembelianController::class, 'destroy'])->name('destroy'); 
    Route::get('/pembelian/{id}/exportpdf', [PembelianController::class, 'exportPdf'])->name('export');
});

});
