<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PortofolioController; // Sebelumnya PortofolioController
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// HAPUS RUTE LAMA INI
// Route::get('/dashboard', function () { ... });

// Grup rute yang memerlukan login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // UBAH NAMA RUTE INI
    Route::get('/dashboard', [DashboardController::class, 'edit'])->name('dashboard'); // Diubah dari 'dashboard.edit'
    
    Route::put('/dashboard', [DashboardController::class, 'update'])->name('dashboard.update');
});

// Rute ini tidak perlu di dalam grup 'auth' karena untuk publik
Route::get('/portfolio/{portfolio:slug}', [PortofolioController::class, 'show'])->name('portofolio.show');

require __DIR__.'/auth.php';