@php
    use Carbon\Carbon;
@endphp

<x-app-layout>

    <div class="py-12 mt-[5%]">
        <div class="flex flex-col gap-4 max-w-7xl mx-auto px-6 lg:px-8">
            <h2 class="text-2xl font-bold">Your Stats</h2>
            <div class="flex flex-wrap gap-6">
                <x-metric-card value="{{ $user_stats['today'] }}" label="Cups of coffee today" />
                <x-metric-card value="{{ $user_stats['this_week'] }}" label="Total this week" />
                <x-metric-card value="{{ $user_stats['this_month'] }}" label="Total this month" />
                <x-metric-card value="{{ $user_stats['personal_best'] }}" label="Personal best (day)" />
                <x-metric-card
                    value="{{ $user_stats['last_coffee_time'] ? Carbon::createFromDate($user_stats['last_coffee_time'])->diffForHumans() : 'Never' }}"
                    label="Last coffee time" />
                <x-metric-card value="{{ $user_stats['rank'] }}" label="Rank" />
            </div>

            <h2 class="text-2xl font-bold mt-8">Your Department Stats ({{ Auth::user()->department->name }})</h2>
            <div class="flex flex-wrap gap-6 justify-center">
                <x-metric-card value="{{ $dep_stats['today'] }}" label="Cups today" />
                <x-metric-card value="{{ $dep_stats['cpp'] }}" label="Today's CPP (Cups per person)" />
                <x-metric-card value="{{ $dep_stats['this_month'] }}" label="Cups this month" />
                <x-metric-card value="{{ $dep_stats['members'] }}" label="Members" />
                <x-metric-card value="{{ $dep_stats['rank'] }}" label="Department rank" />
            </div>

            <h2 id="timeline" class="text-2xl font-bold mt-8">Personal Timeline</h2>
            <div class="flex flex-col gap-2 bg-white rounded-2xl shadow-lg p-2 sm:p-4">
                @forelse ($user_stats['last_n_coffees'] as $coffee)
                    <div
                        class="flex items-center gap-4 p-3 rounded-lg bg-gray-50 shadow-sm hover:bg-yellow-50 transition">
                        <span class="inline-block w-2 h-2 rounded-full bg-red-400"></span>
                        <span class="font-semibold text-gray-800 local-coffee-date"
                            data-iso="{{ $coffee->consumed_at }}"></span>
                        <span class="text-gray-500 text-sm ml-auto local-coffee-time"
                            data-iso="{{ $coffee->consumed_at }}"></span>
                    </div>
                @empty
                    <div class="text-gray-400 text-center py-4">No coffee entries yet.</div>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $user_stats['last_n_coffees']->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
