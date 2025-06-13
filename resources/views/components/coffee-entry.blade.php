<div class="flex flex-col gap-2">
    <div class="flex w-full items-center gap-4 p-3 rounded-lg bg-gray-50 shadow-sm hover:bg-yellow-50 transition-all">
        <span class="inline-block w-2 h-2 rounded-full bg-red-400"></span>
        <span class="font-semibold text-gray-800 local-coffee-date" data-iso="{{ $coffee->consumed_at }}"></span>
        <span class="text-gray-500 text-sm ml-auto local-coffee-time" data-iso="{{ $coffee->consumed_at }}"></span>
        @if (isset($showUser) && $showUser && isset($coffee->user))
            <a href="{{ route('user.view', ['id' => $coffee->user->id]) }}"
                class="ml-4 text-blue-700 hover:underline font-semibold flex items-center gap-1">
                <x-lucide-user class="w-4 h-4" /> {{ $coffee->user->name }}
            </a>
        @endif
    </div>
    @if ($coffee->is_custom)
        <div
            class="flex flex-col w-full gap-4 p-3 rounded-lg bg-yellow-50 shadow-sm hover:bg-yellow-100 transition-all">
            <div class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-yellow-400"></span>
                <span class="font-bold text-lg text-yellow-900 flex gap-2 items-center">{{ $coffee->title }}
                    <span
                        class="inline-block px-2 py-0.5 text-xs rounded-md bg-yellow-600 text-white font-bold">{{ $coffee->type }}</span>
                </span>
            </div>
            <div class="text-gray-700 text-sm">{{ $coffee->desc }}</div>
            @if (!empty($coffee->img_url))
                <div
                    class="flex-shrink-0 w-[20rem] h-[20rem] rounded-md overflow-hidden border border-yellow-200 bg-white flex items-center justify-center">
                    <img src="{{ $coffee->img_url }}" alt="Coffee image" class="object-contain w-full h-full" />
                </div>
            @endif
        </div>
    @endif
</div>
