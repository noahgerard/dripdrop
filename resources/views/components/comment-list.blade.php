@props(['comments'])

<div class="flex flex-col gap-2 ml-4">
    @foreach ($comments as $comment)
        <div class="flex gap-2 group">
            <img src="{{ $comment->user->avatar() }}" class="w-6 h-6 rounded-full" />
            <div class="flex flex-col">
                <div class="flex items-center gap-2">
                    <a href={{ route('user.view', parameters: ['id' => $comment->user->id]) }}
                        class="font-medium hover:underline">{{ $comment->user->name }}</a>
                    <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                <span>{{ $comment->content }}</span>
            </div>

            @if ($comment->user_id == Auth::id())
                <div class="ml-auto relative" x-data="{ open: false }">
                    <button @click="open = !open" @keydown.escape="open = false" @click.away="open = false"
                        type="button"
                        class="focus:outline-none inline-flex items-center px-2 py-2 border border-transparent rounded-md text-gray-500 bg-white hover:cursor-pointer">
                        <x-lucide-ellipsis-vertical class="w-3 h-3 text-slate-500" />
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute right-0 mt-2 w-32 bg-white border rounded shadow-lg z-10 py-2 flex flex-col"
                        style="display: none;">
                        <form method="POST" action="{{ route('comment.delete') }}">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="id" value="{{ $comment->id }}">
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">Delete</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    @endforeach
</div>
