<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coffee extends Model
{
    protected $fillable = [
        'user_id',
        'consumed_at',
        'title',
        'desc',
        'img_url',
        'del_img_url',
        'type',
    ];

    protected $casts = [
        'consumed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function chart_data()
    {
        // Chart data (last 30 days)
        $dates = collect(range(0, 29))->map(function ($i) {
            return now()->copy()->subDays(29 - $i)->toDateString();
        });

        // Fetch coffees consumed in last 30 days
        $coffeeCounts = self::where('consumed_at', '>=', now()->copy()->subDays(29))
            ->get()
            ->groupBy(function ($coffee) {
                return $coffee->consumed_at->toDateString();
            });

        // Map dates to number of coffees that day
        $coffee_chart_data = $dates->map(function ($date) use ($coffeeCounts) {
            return [
                'date' => $date,
                'count' => isset($coffeeCounts[$date]) ? $coffeeCounts[$date]->count() : 0,
            ];
        });

        return $coffee_chart_data;
    }
}
