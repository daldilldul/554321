<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\SiswaController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin routes
    // Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
        Route::get('/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
        Route::get('/users/{id}/transactions', [AdminController::class, 'userTransactions'])->name('users.transactions');
        Route::get('/users/{id}/transactions/pdf', [AdminController::class, 'downloadPdf'])->name('users.transactions.pdf');
    // });

    // Bank routes
    // Route::middleware('role:bank')->prefix('bank')->name('bank.')->group(function () {
        Route::get('/bank', [BankController::class, 'dashboard'])->name('bank.dashboard');
        Route::get('/siswa', [BankController::class, 'siswaList'])->name('siswa.list');
        Route::get('/siswa/create', [BankController::class, 'createSiswa'])->name('siswa.create');
        Route::post('/siswa', [BankController::class, 'storeSiswa'])->name('siswa.store');
        Route::get('/siswa/{id}/edit', [BankController::class, 'editSiswa'])->name('siswa.edit');
        Route::put('/siswa/{id}', [BankController::class, 'updateSiswa'])->name('siswa.update');
        Route::delete('/siswa/{id}', [BankController::class, 'deleteSiswa'])->name('siswa.delete');
        Route::get('/topup/{id?}', [BankController::class, 'topupForm'])->name('topup.form');
        Route::post('/topup', [BankController::class, 'processTopup'])->name('topup.process');
        Route::post('/transactions/{id}/approve', [BankController::class, 'approveTransaction'])->name('transactions.approve');
        Route::post('/transactions/{id}/reject', [BankController::class, 'rejectTransaction'])->name('transactions.reject');
    // });

    // Siswa routes
    // Route::middleware('role:siswa')->prefix('siswa')->name('siswa.')->group(function () {
        // Route::get('/siswa', [SiswaController::class, 'dashboard'])->name('dashboard');
        // Route::get('/topup', [SiswaController::class, 'topupForm'])->name('topup.form');
        // Route::post('/topup', [SiswaController::class, 'requestTopup'])->name('topup.request');
        // Route::get('/transfer', [SiswaController::class, 'transferForm'])->name('transfer.form');
        // Route::post('/transfer', [SiswaController::class, 'processTransfer'])->name('transfer.process');
        // Route::get('/withdraw', [SiswaController::class, 'withdrawForm'])->name('withdraw.form');
        // Route::post('/withdraw', [SiswaController::class, 'requestWithdraw'])->name('withdraw.request');
        // Route::get('/transactions', [SiswaController::class, 'transactions'])->name('transactions');
    // });
});
