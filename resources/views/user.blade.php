<x-app-layout>
    <div class="py-12 mt-[5%]">
        <div class="flex flex-col gap-4 max-w-7xl mx-auto px-6 lg:px-8">
            <a class="text-2xl font-bold">
                @if ($is_me)
                    Your Stats
                @else
                    {{ $user->name }}'s Stats
                @endif
                </h2>
            </a>
            <x-user-stats :user_stats="$user_stats" />


            <a href="{{ route('department.view', parameters: ['id' => $user->department->id]) }}"
                class="text-2xl font-bold mt-8 hover:underline">
                @if ($is_me)
                    Your Department Stats ({{ $user->department->name }})
                @else
                    {{ $user->department->name ?? 'Department' }}'s Stats
                @endif
                🔗
            </a>

            <x-department-stats :dep_stats="$dep_stats" />

            <h2 class="text-2xl font-bold mt-8">Coffee Chart</h2>
            <x-coffee-chart :chart_data="$coffee_chart_data" id="userCoffeeChart" />

            <div class="flex justify-between items-end mt-8">
                <h2 id="timeline" class="text-2xl font-bold">
                    @if ($is_me)
                        Your Coffees
                    @else
                        {{ $user->name }}'s Coffees
                    @endif
                </h2>
            </div>

            <div class="flex flex-col gap-4">
                @forelse ($user_stats['last_n_coffees'] as $coffee)
                    <x-coffee-entry :coffee="$coffee" />
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
