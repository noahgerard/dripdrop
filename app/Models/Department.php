<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // All coffees owned
    public function coffees()
    {
        return $this->hasManyThrough(Coffee::class, User::class);
    }

    public function stats()
    {
        $now = now();
        $today = $now->copy()->startOfDay();
        $month = $now->copy()->startOfMonth();

        $users = $this->users();
        $cups_today = $this->coffees()->where('consumed_at', '>=', $today)->count();
        $cups_month = $this->coffees()->where('consumed_at', '>=', $month)->count();

        return [
            'today' => $cups_today,
            'cpp' => number_format($cups_today / $users->count(), 2),
            'this_month' => $cups_month,
            'members' => $users->count(),
            'rank' => 1
        ];
    }

    public static function leaderboard()
    {
        return self::withCount(['coffees', 'users'])
            ->orderByDesc('coffees_count')
            ->whereExists(function ($query) {
                $query->selectRaw(1)
                    ->from('users')
                    ->whereColumn('users.department_id', 'departments.id');
            })
            ->paginate(10);
    }
}
