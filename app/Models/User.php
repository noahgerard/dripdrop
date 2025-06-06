<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'department_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function coffees()
    {
        return $this->hasMany(Coffee::class);
    }

    public function stats()
    {
        $now = now();
        $days_since_creation = $now->diffInDays($now);
        $today = $now->copy()->startOfDay();
        $weekStart = $now->copy()->startOfWeek();
        $monthStart = $now->copy()->startOfMonth();

        $totalCoffees = $this->coffees()->count();

        $last_n_coffees = $this->coffees()->orderBy('consumed_at', 'desc')->paginate(10);

        // Calculate rank: how many users have more coffees than this user?
        $rank = self::whereRaw(
            '(select count(*) from coffees where coffees.user_id = users.id) > ?',
            [$totalCoffees]
        )
            ->where('id', '!=', $this->id)
            ->count() + 1;

        return [
            'today' => $this->coffees()->where('consumed_at', '>=', $today)->count(),
            'this_week' => $this->coffees()->where('consumed_at', '>=', $weekStart)->count(),
            'this_month' => $this->coffees()->where('consumed_at', '>=', $monthStart)->count(),
            'personal_best' => $this->coffees()
                ->selectRaw('DATE(consumed_at) as day, COUNT(*) as count')
                ->groupBy('day')
                ->orderByDesc('count')
                ->value('count') ?? 0,
            'last_coffee_time' => optional($this->coffees()->latest('consumed_at')->first())->consumed_at,
            'last_n_coffees' => $last_n_coffees,
            'avg_cups_per_day' => number_format($totalCoffees / max($days_since_creation, 1), 2),
            'total' => $totalCoffees,
            'rank' => $rank,
        ];
    }

    public static function leaderboard()
    {
        $weekAgo = now()->subWeek();

        $users = User::with('department')
            ->withCount([
                'coffees as coffees_count' => function ($query) use ($weekAgo) {
                    $query->where('consumed_at', '>=', $weekAgo);
                }
            ])
            ->orderByDesc('coffees_count')
            ->paginate(10, ['*'], 'user_lb');

        return $users;
    }
}
