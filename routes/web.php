<?php

use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CoffeeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('home');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'view'])->name('dashboard');
    Route::get('/leaderboard', [LeaderboardController::class, 'view'])->name('leaderboard');

    Route::get('/department/{id}', [DepartmentController::class, 'show'])->name('department.show');
    Route::get('/user/{id}', [ProfileController::class, 'show'])->name('user.view');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/coffee.php';
