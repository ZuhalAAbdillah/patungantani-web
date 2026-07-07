<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\KuponController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\PageController;
use App\Models\Campaign;
use Illuminate\Support\Facades\Route;

// ── Public & Landing Page ──
Route::get('/', [DashboardController::class, 'welcome'])->name('home');

// ── Public Pages (Standalone) ──
Route::get('/cara-kerja', [PageController::class, 'caraKerja'])->name('page.cara-kerja');
Route::get('/keunggulan', [PageController::class, 'keunggulan'])->name('page.keunggulan');
Route::get('/pre-order', [PageController::class, 'preOrder'])->name('page.pre-order');

// ── Authenticated Routes ──
Route::middleware('auth')->group(function () {

    // Dashboard (Role-based)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/export-csv', [DashboardController::class, 'exportCsv'])->name('dashboard.export-csv');

    // Pesanan Saya
    Route::get('/orders', [OrderHistoryController::class, 'index'])->name('orders.index');

    // Order flow
    Route::post('/order/{campaign}', [OrderController::class, 'store'])->name('order.store');
    Route::get('/payment/{order}', [OrderController::class, 'payment'])->name('order.payment');
    Route::post('/payment/{order}/complete', [OrderController::class, 'completePayment'])->name('order.complete');

    // Kupon
    Route::get('/kupon/{allocation}', [KuponController::class, 'show'])->name('kupon.show');

    // Campaign management (ketua & admin)
    Route::middleware('role:ketua,admin')->group(function () {
        Route::get('/campaign/create', [CampaignController::class, 'create'])->name('campaign.create');
        Route::post('/campaign', [CampaignController::class, 'store'])->name('campaign.store');
    });

    // Scan QR (ketua & admin)
    Route::middleware('role:ketua,admin')->group(function () {
        Route::get('/scan', [ScanController::class, 'index'])->name('scan');
        Route::post('/scan/verify', [ScanController::class, 'verify'])->name('scan.verify');
    });

    // Laporan Keuangan (admin only)
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/finance', [DashboardController::class, 'finance'])->name('admin.finance');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
