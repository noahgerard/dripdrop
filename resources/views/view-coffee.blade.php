<x-app-layout>
    <div class="py-12 mt-[5%]">
        <div class="flex flex-col gap-4 max-w-3xl mx-auto px-6 lg:px-8">
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline mb-2">← Back to Dashboard</a>
            <h2 class="text-2xl font-bold mb-4">Coffee Entry</h2>

            @if ($coffee)
                <x-coffee-entry :coffee="$coffee" />
            @else
                <div class="text-gray-400 text-center py-4">Coffee not found.</div>
            @endif
        </div>
    </div>
</x-app-layout>
