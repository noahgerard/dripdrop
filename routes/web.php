<?php

use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FeedController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [UserController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [UserController::class, 'show'])->name('dashboard');
    Route::get('/leaderboard', [LeaderboardController::class, 'show'])->name('leaderboard');
    Route::get('/feed', [FeedController::class, 'show'])->name('feed.view');

    Route::get('/department/{id}', [DepartmentController::class, 'show'])->name('department.view');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('user.view');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/coffee.php';
require __DIR__ . '/comment.php';
