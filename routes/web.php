<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConsultationController;

// ====================================================
// 1. HALAMAN PUBLIK & OTENTIKASI
// ====================================================

// Halaman Depan (Landing Page)
Route::get('/', function () { return view('landing'); })->name('home');

// Login & Register
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ====================================================
// 2. AREA USER (MASYARAKAT / ORANG TUA)
// ====================================================
Route::middleware(['auth'])->group(function () {
    // Dashboard & Input Data Anak
    Route::get('/user/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
    Route::post('/user/check', [DashboardController::class, 'userStore'])->name('user.store');
    
    // Fitur Konsultasi (Chat)
    Route::get('/user/konsultasi', [ConsultationController::class, 'indexUser'])->name('user.consultation');
    Route::post('/user/konsultasi', [ConsultationController::class, 'store'])->name('user.consultation.store');
});

// ====================================================
// 3. AREA KADER (POSYANDU)
// ====================================================
Route::middleware(['auth', 'role:kader'])->group(function () {
    // Dashboard Utama Kader
    Route::get('/kader/dashboard', [DashboardController::class, 'kaderDashboard'])->name('kader.dashboard');
    
    // Balas Konsultasi Warga
    Route::post('/kader/reply/{id}', [ConsultationController::class, 'reply'])->name('kader.reply');

    // Manajemen Data (Edit & Hapus Data Salah)
    Route::get('/kader/record/{id}/edit', [DashboardController::class, 'editRecord'])->name('kader.editRecord');
    Route::put('/kader/record/{id}', [DashboardController::class, 'updateRecord'])->name('kader.updateRecord');
    Route::delete('/kader/record/{id}', [DashboardController::class, 'deleteRecord'])->name('kader.deleteRecord');
});

// ====================================================
// 4. AREA ADMIN (SISTEM)
// ====================================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard Admin
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    
    // Manajemen User (Buat Akun Admin/Kader Baru & Hapus User)
    Route::post('/admin/create-user', [DashboardController::class, 'createUser'])->name('admin.createUser');
    Route::delete('/admin/user/{id}', [DashboardController::class, 'deleteUser'])->name('admin.deleteUser');
});

// ====================================================
// 5. RUTE PENYELAMAT (TRAFFIC COP)
// ====================================================
// Rute ini menangani tombol "Dashboard" di Landing Page
// dan mengarahkan user ke halaman yang benar sesuai Role-nya.
Route::get('/dashboard', [DashboardController::class, 'redirectUser'])
    ->middleware(['auth'])
    ->name('dashboard');