<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Session;

// public routes
Route::get('/', [LeaderboardController::class, 'index'])->name('leaderboard.index');
Route::post('/update-all', [LeaderboardController::class, 'updateAll'])->name('leaderboard.updateAll');
Route::post('/summoner/{id}/update', [LeaderboardController::class, 'update'])->name('leaderboard.update');
Route::get('/summoner/{id}/history', [LeaderboardController::class, 'history'])->name('leaderboard.history');

// auth routes
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// admin routes (protected)
Route::middleware(['admin.auth'])->group(function () {
    Route::get('/admin', function () {
        return view('admin');
    })->name('admin.index');
    
    Route::post('/summoner', [LeaderboardController::class, 'store'])->name('leaderboard.store');
    Route::delete('/summoner/{id}', [LeaderboardController::class, 'destroy'])->name('leaderboard.destroy');
});


