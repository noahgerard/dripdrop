<?php

namespace App\Http\Controllers;

use App\Models\Coffee;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    /**
     * Fetches leaderboard and returns leaderboard view
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Request $request): View
    {
        $user_leaderboard = User::leaderboard();
        $dep_leaderboard = Department::leaderboard();
        $coffee_chart_data = Coffee::chart_data();

        return view('leaderboard', [
            'user_leaderboard' => $user_leaderboard,
            'dep_leaderboard' => $dep_leaderboard,
            'coffee_chart_data' => $coffee_chart_data
        ]);
    }
}
