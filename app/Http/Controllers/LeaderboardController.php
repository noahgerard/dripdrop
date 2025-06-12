<?php

namespace App\Http\Controllers;

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
    public function view(Request $request): View
    {
        // Time to Live (minutes)
        $ttl = 60 * 5;

        $userPage = $request->input('user_lb', 1);
        $depPage = $request->input('dep_lb', 1);

        $user_leaderboard = User::leaderboard();
        $dep_leaderboard = Department::leaderboard();

        return view('leaderboard', ['user_leaderboard' => $user_leaderboard, 'dep_leaderboard' => $dep_leaderboard]);
    }
}
