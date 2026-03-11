<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProdukController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::redirect('/', '/dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/master-data/master-produk', [ProdukController::class, 'index'])->name('masterdata.masterproduk');
    Route::post('/master-data/master-produk', [ProdukController::class, 'store'])->name('masterdata.masterproduk.store');

    Route::get('/master-data/master-produk/template/download', [ProdukController::class, 'downloadTemplate'])
        ->name('masterdata.masterproduk.template.download');
    Route::post('/master-data/master-produk/import', [ProdukController::class, 'import'])
    ->name('masterdata.masterproduk.import');

    Route::get('/master-data/master-produk/export', [ProdukController::class, 'exportEditTemplate'])
    ->name('masterdata.masterproduk.export');

    Route::post('/master-data/master-produk/import-update', [ProdukController::class, 'importUpdate'])
        ->name('masterdata.masterproduk.importUpdate');

    Route::put('/master-data/master-produk/{produk}', [ProdukController::class, 'update'])->name('masterdata.masterproduk.update');
    Route::delete('/master-data/master-produk/{produk}', [ProdukController::class, 'destroy'])->name('masterdata.masterproduk.destroy');

    Route::get('/master-data/master-kategori', function () {
        return view('masterdata.masterkategori');
    })->name('masterdata.masterkategori');

    Route::get('/master-data/master-satuan', function () {
        return view('masterdata.mastersatuan');
    })->name('masterdata.mastersatuan');

    Route::get('/master-data/master-rak', function () {
        return view('masterdata.masterrak');
    })->name('masterdata.masterrak');

    Route::get('/master-data/master-gudang', function () {
        return view('masterdata.mastergudang');
    })->name('masterdata.mastergudang');

    Route::prefix('control-user')->name('users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/create', [UserManagementController::class, 'create'])->name('create');
        Route::post('/', [UserManagementController::class, 'store'])->name('store');

        Route::get('/custom-priv', function () {
            $roles = collect([
                (object) ['name' => 'admin', 'is_active' => true],
                (object) ['name' => 'user', 'is_active' => true],
                (object) ['name' => 'kasir', 'is_active' => true],
            ]);

            return view('users.hakakses.custompriv', compact('roles'));
        })->name('custompriv');

        Route::get('/{user}/edit', [UserManagementController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserManagementController::class, 'update'])->name('update');
        Route::patch('/{user}/toggle', [UserManagementController::class, 'toggle'])->name('toggle');
        Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
    });

    Route::get('/penjualan/kasir', function () {
        return view('Penjualan.kasir');
    })->name('penjualan.kasir');
});