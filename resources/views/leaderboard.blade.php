<x-app-layout>
    <div class="py-12 mt-[5%]">
        <div class="flex flex-col gap-4 max-w-7xl mx-auto px-6 lg:px-8">
            <h2 class="text-2xl font-bold">User Leaderboard ({{ $user_leaderboard->count() }})</h2>
            <div class="flex flex-col gap-2 bg-white rounded-2xl shadow-lg p-2 sm:p-4">
                @forelse ($user_leaderboard as $user)
                    <div
                        class="flex items-center gap-4 p-3 rounded-lg bg-gray-50 shadow-sm hover:bg-yellow-50 transition">
                        <span class="inline-block w-2 h-2 rounded-full bg-red-400"></span>

                        <span class="font-semibold text-gray-800">{{ $user->name }}
                            [{{ $user->department->name }}]</span>

                        @if ($user->id == Auth::user()->id)
                            <span
                                class="inline-block px-2 py-0.5 text-xs rounded-md bg-green-600 text-white font-bold">You</span>
                        @endif
                        <span class="text-gray-500 text-sm ml-auto">{{ $user->coffees_count }} coffees</span>
                    </div>
                @empty
                    <div class="text-gray-400 text-center py-4">No coffee entries yet.</div>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $user_leaderboard->links() }}
            </div>

            <div class="flex flex-row justify-between items-end mt-8">
                <h2 class="text-2xl font-bold">Department Leaderboard</h2>
                <h2 class="text-md text-gray-400">Updates every 5 minutes</h2>
            </div>
            <div class="flex flex-col gap-2 bg-white rounded-2xl shadow-lg p-2 sm:p-4">
                @forelse ($dep_leaderboard as $dep)
                    <div
                        class="flex items-center gap-4 p-3 rounded-lg bg-gray-50 shadow-sm hover:bg-yellow-50 transition">
                        <span class="inline-block w-2 h-2 rounded-full bg-red-400"></span>
                        <span class="font-semibold text-gray-800">{{ $dep->name }} ({{ $dep->users_count }})</span>
                        <span class="text-gray-500 text-sm ml-auto">{{ $dep->coffees_count }} coffees</span>
                    </div>
                @empty
                    <div class="text-gray-400 text-center py-4">No coffee entries yet.</div>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $dep_leaderboard->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
