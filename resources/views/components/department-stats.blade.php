@props(['dep_stats'])

<div class="flex flex-wrap gap-6">
    <x-metric-card :value="$dep_stats['today']" label="Cups today" />
    <x-metric-card :value="$dep_stats['cpp']" label="Today's Cups/Member" />
    <x-metric-card :value="$dep_stats['rank']" label="Department rank" />
    <x-metric-card :value="$dep_stats['this_month']" label="Cups this month" />
    <x-metric-card :value="$dep_stats['members']" label="Members" />
</div>
