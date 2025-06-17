<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function show($id): View
    {
        $department = Department::with(['coffees.user'])
            ->findOrFail($id);
        $dep_stats = $department->stats();

        // Paginate users
        $users = $department->users()->paginate(10, ['*'], 'users');

        // Chart data (last 30 days)
        $dates = collect(range(0, 29))->map(function ($i) {
            return now()->copy()->subDays(29 - $i)->toDateString();
        });
        $coffeeCounts = $department->coffees()
            ->where('consumed_at', '>=', now()->copy()->subDays(29))
            ->get()
            ->groupBy(function ($coffee) {
                return $coffee->consumed_at->toDateString();
            });
        $coffee_chart_data = $dates->map(function ($date) use ($coffeeCounts) {
            return [
                'date' => $date,
                'count' => isset($coffeeCounts[$date]) ? $coffeeCounts[$date]->count() : 0,
            ];
        });

        // Recent department coffees (paginated)
        $recent_coffees = $department->coffees()->with('user')->orderByDesc('consumed_at')->paginate(10, ['*'], 'coffees');

        return view('department', [
            'department' => $department,
            'dep_stats' => $dep_stats,
            'users' => $users,
            'coffee_chart_data' => $coffee_chart_data,
            'recent_coffees' => $recent_coffees,
        ]);
    }
}
