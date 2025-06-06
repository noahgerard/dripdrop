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
        $totalCoffees = $this->coffees()->count();
        $cups_today = $this->coffees()->where('consumed_at', '>=', $today)->count();
        $cups_month = $this->coffees()->where('consumed_at', '>=', $month)->count();

        $rank = self::whereRaw(
            '(select count(*) from coffees
            inner join users on users.id = coffees.user_id
            where users.department_id = departments.id
        ) > ?',
            [$totalCoffees]
        )
            ->where('id', '!=', $this->id)
            ->count() + 1;

        return [
            'today' => $cups_today,
            'cpp' => number_format($cups_today / $users->count(), 2),
            'this_month' => $cups_month,
            'members' => $users->count(),
            'rank' => $rank
        ];
    }

    public static function leaderboard()
    {
        $weekAgo = now()->subWeek();

        return self::withCount([
            'coffees as coffees_count' => function ($query) use ($weekAgo) {
                $query->where('consumed_at', '>=', $weekAgo);
            },
            'users'
        ])
            ->orderByDesc('coffees_count')
            ->whereExists(function ($query) {
                $query->selectRaw(1)
                    ->from('users')
                    ->whereColumn('users.department_id', 'departments.id');
            })
            ->paginate(10);
    }
}
