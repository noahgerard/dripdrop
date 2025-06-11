<?php

namespace App\Http\Controllers;

use App\Models\Coffee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user_leaderboard = $request->user()->leaderboard();
        $dep_leaderboard = $request->user()->department->leaderboard();

        return view('leaderboard', ['user_leaderboard' => $user_leaderboard, 'dep_leaderboard' => $dep_leaderboard]);
    }
}
