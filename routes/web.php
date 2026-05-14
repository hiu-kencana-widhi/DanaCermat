<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\PaymentCategoryController;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rute user biasa
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');
    Route::resource('transactions', TransactionController::class);
    
    // Rute profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk data anggaran
    Route::post('/budgets', [App\Http\Controllers\User\BudgetController::class, 'store'])->name('budgets.store');
    Route::delete('/budgets/{budget}', [App\Http\Controllers\User\BudgetController::class, 'destroy'])->name('budgets.destroy');

    // Rute untuk Tagihan/Rencana
    Route::post('/bills', [App\Http\Controllers\User\BillController::class, 'store'])->name('bills.store');
    Route::patch('/bills/{bill}/toggle', [App\Http\Controllers\User\BillController::class, 'togglePaid'])->name('bills.toggle');
    Route::delete('/bills/{bill}', [App\Http\Controllers\User\BillController::class, 'destroy'])->name('bills.destroy');

    // Rute Laporan
    Route::get('/reports', [App\Http\Controllers\User\ReportController::class, 'index'])->name('reports.index');
    Route::get('/export/transactions', [App\Http\Controllers\User\ReportController::class, 'exportPdf'])->name('transactions.export');
});

// Rute admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('payment-categories', PaymentCategoryController::class);
    Route::resource('payment-methods', PaymentMethodController::class);
});

require __DIR__.'/auth.php';