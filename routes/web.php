<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaderboardController;

Route::get('/', [LeaderboardController::class, 'index'])->name('leaderboard.index');
Route::post('/summoner', [LeaderboardController::class, 'store'])->name('leaderboard.store');
Route::post('/update-all', [LeaderboardController::class, 'updateAll'])->name('leaderboard.updateAll');

