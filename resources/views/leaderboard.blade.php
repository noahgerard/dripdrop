<x-app-layout>
    <div class="py-12 mt-[5%]">
        <div class="flex flex-col gap-4 max-w-7xl mx-auto px-6 lg:px-8">
            <h2 class="text-2xl font-bold">User Leaderboard</h2>
            <div class="flex flex-col gap-2 bg-white rounded-2xl shadow-lg p-2 sm:p-4">
                @forelse ($user_leaderboard as $user)
                    <div
                        class="flex items-center gap-4 p-3 rounded-lg bg-gray-50 shadow-sm hover:bg-yellow-50 transition">
                        <span class="inline-block w-2 h-2 rounded-full bg-red-400"></span>
                        <span class="font-semibold text-gray-800">{{ $user->name }}</span>
                        <span class="text-gray-500 text-sm ml-auto">{{ $user->coffees_count }} coffees</span>
                    </div>
                @empty
                    <div class="text-gray-400 text-center py-4">No coffee entries yet.</div>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $user_leaderboard->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
