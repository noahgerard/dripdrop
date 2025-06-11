<?php

namespace App\Http\Controllers;

use App\Models\Coffee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Fetches and aggregates dashboard stats and returns
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function view(Request $request): View
    {
        $user_stats = $request->user()->stats();
        $dep_stats = $request->user()->department->stats();

        // Get last 30 days' dates and coffee counts
        $dates = collect(range(0, 29))->map(function ($i) {
            return Carbon::today()->subDays(29 - $i)->toDateString();
        });

        $coffeeCounts = Coffee::where('user_id', $request->user()->id)
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
    }
}
