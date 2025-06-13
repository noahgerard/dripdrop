@props(['user_stats'])
@php
    use Carbon\Carbon;
@endphp

<div class="flex flex-wrap gap-6">
    <x-metric-card :value="$user_stats['today']" label="Cups of coffee today" />
    <x-metric-card :value="$user_stats['this_week']" label="Cups this week" />
    <x-metric-card :value="$user_stats['this_month']" label="Cups this month" />
    <x-metric-card :value="$user_stats['personal_best']" label="Personal best (day)" />
    <x-metric-card :value="$user_stats['last_coffee_time']
        ? Carbon::createFromDate($user_stats['last_coffee_time'])->diffForHumans()
        : 'Never'" label="Last coffee time" />
    <x-metric-card :value="$user_stats['total']" label="All-Time" />
    <x-metric-card :value="$user_stats['avg_cups_per_day']" label="Avg. Cups/Day" />
    <x-metric-card :value="$user_stats['rank']" label="Rank" />
</div>
