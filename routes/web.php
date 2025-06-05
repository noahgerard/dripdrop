<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function (Request $request) {
    $user_stats = $request->user()->stats();
    $dep_stats = $request->user()->department->stats();

    return view('dashboard', ['user_stats' => $user_stats, 'dep_stats' => $dep_stats]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/leaderboard', function (Request $request) {
    $user_leaderboard = $request->user()->leaderboard();
    $dep_leaderboard = $request->user()->department->leaderboard();

    return view('leaderboard', ['user_leaderboard' => $user_leaderboard, 'dep_leaderboard' => $dep_leaderboard]);
})->middleware(['auth', 'verified'])->name('leaderboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/coffee.php';
