<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Coffee;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function (Request $request) {
    $user_stats = $request->user()->stats();
    $dep_stats = $request->user()->department->stats();

    $user = Auth::user();

    // Get last 30 days' dates and coffee counts
    $dates = collect(range(0, 29))->map(function ($i) {
        return Carbon::today()->subDays(29 - $i)->toDateString();
    });

    $coffeeCounts = Coffee::where('user_id', $user->id)
        ->where('consumed_at', '>=', Carbon::today()->subDays(29))
        ->get()
        ->groupBy(function ($coffee) {
            return Carbon::parse($coffee->consumed_at)->toDateString();
        });

    $chartData = $dates->map(function ($date) use ($coffeeCounts) {
        return [
            'date' => $date,
            'count' => isset($coffeeCounts[$date]) ? $coffeeCounts[$date]->count() : 0,
        ];
    });

    return view('dashboard', [
        'user_stats' => $user_stats,
        'dep_stats' => $dep_stats,
        'coffee_chart_data' => $chartData,
    ]);
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
