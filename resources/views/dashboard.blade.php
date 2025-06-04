<x-app-layout>

    <div class="py-12 mt-[5%]">
        <div class="flex flex-col gap-4 max-w-7xl mx-auto px-6 lg:px-8">
            <h2 class="text-2xl font-bold">Your Stats</h2>
            <div class="flex flex-wrap gap-6">
                <x-metric-card value="5" label="Cups of coffee today" />
                <x-metric-card value="12" label="Total this week" />
                <x-metric-card value="34" label="Total this month" />
                <x-metric-card value="7" label="Personal best (day)" />
                <x-metric-card value="2:15 PM" label="Last coffee time" />
                <x-metric-card value="5th" label="Rank" />
            </div>

            <h2 class="text-2xl font-bold mt-8">Your Department Stats (IT)</h2>
            <div class="flex flex-wrap gap-6 justify-center">
                <x-metric-card value="18" label="Cups today" />
                <x-metric-card value="18" label="Today's CPP (Cups per person)" />
                <x-metric-card value="102" label="Cups this month" />
                <x-metric-card value="7" label="Members" />
                <x-metric-card value="2nd" label="Department rank" />
            </div>

            <h2 class="text-2xl font-bold mt-8">Personal Timeline</h2>
            <div class="flex flex-col gap-2 bg-white rounded-2xl shadow-lg px-2 sm:px-8 py-4 sm:py-6">
                test
            </div>
        </div>
    </div>
</x-app-layout>
