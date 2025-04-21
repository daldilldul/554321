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
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        Route::get('/admin/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
        Route::get('/users/{id}/transactions', [AdminController::class, 'userTransactions'])->name('admin.users.transactions');
        Route::get('/users/{id}/transactions/pdf', [AdminController::class, 'downloadPdf'])->name('admin.users.transactions.pdf');
    // });

    // Bank routes
    // Route::middleware('role:bank')->prefix('bank')->name('bank.')->group(function () {
        Route::get('/bank/dashboard', [BankController::class, 'dashboard'])->name('bank.dashboard');
        Route::get('/siswa', [BankController::class, 'siswaList'])->name('bank.siswa.list');
        Route::get('/siswa/create', [BankController::class, 'createSiswa'])->name('bank.siswa.create');
        Route::post('/siswa', [BankController::class, 'storeSiswa'])->name('bank.siswa.store');
        Route::get('/siswa/{id}/edit', [BankController::class, 'editSiswa'])->name('bank.siswa.edit');
        Route::put('/siswa/{id}', [BankController::class, 'updateSiswa'])->name('bank.siswa.update');
        Route::delete('/siswa/{id}', [BankController::class, 'deleteSiswa'])->name('bank.siswa.delete');
        Route::get('/topup/{id?}', [BankController::class, 'topupForm'])->name('bank.topup.form');
        Route::post('/topup', [BankController::class, 'processTopup'])->name('bank.topup.process');
        Route::get('/withdraw/{id?}', [BankController::class, 'withdrawForm'])->name('bank.withdraw.form');
        Route::post('/withdraw', [BankController::class, 'processWithdraw'])->name('bank.withdraw.process');
        Route::post('/transactions/{id}/approve', [BankController::class, 'approveTransaction'])->name('bank.transactions.approve');
        Route::post('/transactions/{id}/reject', [BankController::class, 'rejectTransaction'])->name('bank.transactions.reject');
    // });

    // Siswa routes
    // Route::middleware('role:siswa')->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/siswa/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
        Route::post('/siswa/topup', [SiswaController::class, 'requestTopup'])->name('siswa.topup.request');
        Route::post('/transfer', [SiswaController::class, 'processTransfer'])->name('siswa.transfer.process');
        Route::post('/siswa/withdraw', [SiswaController::class, 'requestWithdraw'])->name('siswa.withdraw.request');
    // });
});
