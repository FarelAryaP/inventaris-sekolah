<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\PengajuanController as AdminPengajuanController;


Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes - User/Siswa
Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserAuthController::class, 'login']);
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');


Route::get('/admin', function () {
    return redirect('/admin/login');
});

// Authentication Routes Admin
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

// Admin Routes
Route::middleware(['admin.auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Barang
    Route::resource('barang', BarangController::class);

    // Manajemen Pengajuan
    Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
        Route::get('/', [AdminPengajuanController::class, 'index'])->name('index');
        Route::get('/{pengajuan}', [AdminPengajuanController::class, 'show'])->name('show');
        Route::patch('/{pengajuan}/approve', [AdminPengajuanController::class, 'approve'])->name('approve');
        Route::patch('/{pengajuan}/reject', [AdminPengajuanController::class, 'reject'])->name('reject');
    });
});

Route::get('/register', function () {
    return view('auth.register');
});
