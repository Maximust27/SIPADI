<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosyanduController;

Route::get('/', [PosyanduController::class, 'index'])->name('dashboard');
Route::get('/input', [PosyanduController::class, 'create'])->name('input');
Route::post('/store', [PosyanduController::class, 'store'])->name('store');
Route::get('/register', [PosyanduController::class, 'list'])->name('register');