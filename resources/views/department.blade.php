<x-app-layout>
    <div class="py-12 mt-[5%]">
        <div class="flex flex-col gap-4 max-w-7xl mx-auto px-6 lg:px-8">
            <h2 class="text-2xl font-bold">{{ $department->name }} Department</h2>

            <x-department-stats :dep_stats="$dep_stats" />

            <h2 class="text-2xl font-bold mt-8">Coffee Chart</h2>
            <x-coffee-chart :chart_data="$coffee_chart_data" id="departmentCoffeeChart" />

            <h2 class="text-2xl font-bold mt-8">Members</h2>
            <x-user-list :users="$users" />
            <div class="mt-4">
                {{ $users->appends(['coffees' => $recent_coffees->currentPage()])->links() }}
            </div>

            <h2 class="text-2xl font-bold mt-8">Recent Coffees</h2>
            <div class="flex flex-col gap-4">
                @forelse ($recent_coffees as $coffee)
                    <x-coffee-entry :coffee="$coffee" />
                @empty
                    <div class="text-gray-400 text-center py-4">No coffee entries yet.</div>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $recent_coffees->appends(['users' => $users->currentPage()])->links() }}
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</x-app-layout>
