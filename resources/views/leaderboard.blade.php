@php
    use Carbon\Carbon;
@endphp

<x-app-layout>
    <div class="py-12 mt-[5%]">
        <div class="flex flex-col gap-4 max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-row justify-between items-end mt-8">
                <h2 class="text-2xl font-bold">User Leaderboard ({{ $user_leaderboard->total() }})</h2>
                <h2 class="text-md text-gray-400">This week</h2>
            </div>
            <div class="flex flex-col gap-2 bg-white rounded-2xl shadow-lg p-2 sm:p-4">
                @forelse ($user_leaderboard as $user)
                    <div
                        class="flex items-center gap-4 p-3 rounded-lg bg-gray-50 shadow-sm hover:bg-yellow-50 transition">
                        <span class="inline-block w-2 h-2 rounded-full bg-red-400"></span>

                        <a href="{{ route('user.view', ['id' => $user->id]) }}"
                            class="font-semibold text-gray-800 hover:underline">
                            {{ $user->name }} [{{ $user->department->name }}]
                        </a>

                        <div class="flex gap-2">
                            @if ($user->id == Auth::user()->id)
                                <x-chip color="bg-green-600" label="You" />
                            @endif

                            @if (Carbon::createFromDate($user->created_at)->diffInHours() <= 48)
                                <x-chip color="bg-red-600" label="NEW" />
                            @endif
                        </div>

                        <span class="text-gray-500 text-sm ml-auto">{{ $user->coffees_count }} coffees</span>
                    </div>
                @empty
                    <div class="text-gray-400 text-center py-4">No coffee entries yet.</div>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $user_leaderboard->appends(['dep_lb' => $dep_leaderboard->currentPage()])->links() }}
            </div>

            <div class="flex flex-row justify-between items-end mt-8">
                <h2 class="text-2xl font-bold">Department Leaderboard ({{ $dep_leaderboard->total() }})</h2>
                <h2 class="text-md text-gray-400">This week</h2>
            </div>
            <div class="flex flex-col gap-2 bg-white rounded-2xl shadow-lg p-2 sm:p-4">
                @forelse ($dep_leaderboard as $dep)
                    <div
                        class="flex items-center gap-4 p-3 rounded-lg bg-gray-50 shadow-sm hover:bg-yellow-50 transition">
                        <span class="inline-block w-2 h-2 rounded-full bg-red-400"></span>
                        <a href="{{ route('department.view', ['id' => $dep->id]) }}"
                            class="font-semibold text-gray-800 hover:underline">
                            {{ $dep->name }} ({{ $dep->users_count }})
                        </a>
                        <span class="text-gray-500 text-sm ml-auto">{{ $dep->coffees_count }} coffees</span>
                    </div>
                @empty
                    <div class="text-gray-400 text-center py-4">No coffee entries yet.</div>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $dep_leaderboard->appends(['user_lb' => $user_leaderboard->currentPage()])->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
