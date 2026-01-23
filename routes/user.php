<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\AnakController;
use App\Http\Controllers\User\RemajaController;
use App\Http\Controllers\User\LansiaController;
use App\Http\Controllers\User\RiwayatController;

Route::middleware(['auth', 'check.role:user'])->prefix('user')->name('user.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
    });
    
    // Anak (Balita) - untuk orang tua
    Route::prefix('anak')->name('anak.')->group(function () {
        Route::get('/', [AnakController::class, 'index'])->name('index');
        Route::get('/create', [AnakController::class, 'create'])->name('create');
        Route::post('/', [AnakController::class, 'store'])->name('store');
        Route::get('/{id}', [AnakController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AnakController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AnakController::class, 'update'])->name('update');
        Route::delete('/{id}', [AnakController::class, 'destroy'])->name('destroy');
    });
    
    // Remaja - untuk remaja itu sendiri
    Route::prefix('remaja')->name('remaja.')->group(function () {
        Route::get('/', [RemajaController::class, 'index'])->name('index');
        Route::get('/profile/edit', [RemajaController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [RemajaController::class, 'updateProfile'])->name('profile.update');
        Route::get('/pemeriksaan/{id}', [RemajaController::class, 'showPemeriksaan'])->name('pemeriksaan.show');
        Route::get('/konseling/{id}', [RemajaController::class, 'showKonseling'])->name('konseling.show');
    });
    
    // Lansia - untuk lansia itu sendiri
    Route::prefix('lansia')->name('lansia.')->group(function () {
        Route::get('/', [LansiaController::class, 'index'])->name('index');
        Route::get('/profile/edit', [LansiaController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [LansiaController::class, 'updateProfile'])->name('profile.update');
        Route::get('/kunjungan/{id}', [LansiaController::class, 'showKunjungan'])->name('kunjungan.show');
        Route::get('/riwayat-medis', [LansiaController::class, 'riwayatMedis'])->name('riwayat-medis');
    });
    
    // Riwayat Umum
    Route::prefix('riwayat')->name('riwayat.')->group(function () {
        Route::get('/', [RiwayatController::class, 'index'])->name('index');
        Route::get('/{type}/{id}', [RiwayatController::class, 'show'])->name('show');
        Route::get('/export', [RiwayatController::class, 'export'])->name('export');
    });
});