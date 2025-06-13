<x-app-layout>
    <div class="py-12">
        <div class="flex flex-col gap-4 max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col gap-4">
                @forelse ($coffees as $coffee)
                    <x-coffee-entry :coffee="$coffee" />
                @empty
                    <div class="text-gray-400 text-center py-4">No coffee entries yet.</div>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $coffees->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
