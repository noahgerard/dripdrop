@props(['coffee'])

<div class="flex flex-col w-full gap-4 p-6 rounded-lg bg-white shadow-sm transition-all">
    <div class="flex items-center gap-2">
        <div><img src={{ $coffee->user->avatar() }} class="w-10 h-10 rounded-full" alt="Profile Picture"></div>
        <div class="flex flex-col">

            <a href="{{ route('user.view', parameters: ['id' => $coffee->user->id]) }}" class="hover:underline">
                <h2 class="font-semibold">{{ $coffee->user->name }}</h2>
            </a>

            <a href="{{ route('department.view', parameters: ['id' => $coffee->user->department->id]) }}"
                class="hover:underline">
                <h4 class="text-sm text-slate-500">{{ $coffee->user->department->name }}</h4>
            </a>
        </div>
        @if ($coffee->user->id == Auth::user()->id)
            <div class="ml-auto relative" x-data="{ open: false }">
                <button @click="open = !open" @keydown.escape="open = false" @click.away="open = false" type="button"
                    class="focus:outline-none inline-flex items-center px-2 py-2 border border-transparent rounded-md text-gray-500 bg-white hover:text-gray-700 transition ease-in-out duration-150">
                    <x-lucide-ellipsis-vertical class="w-5 h-5" />
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    class="absolute right-0 mt-2 w-40 bg-white border rounded shadow-lg z-10 py-2 flex flex-col"
                    style="display: none;">
                    <a href="{{ route('coffee.editForm', $coffee->id) }}"
                        class="w-full text-left px-4 py-2 text-blue-600 hover:bg-blue-50 flex items-center gap-2">
                        <x-lucide-pencil class="w-4 h-4" /> Edit
                    </a>
                    <form method="POST" action="{{ route('coffee.delete') }}">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="id" value="{{ $coffee->id }}">
                        <button type="submit"
                            class="w-full flex items-center gap-2 px-4 py-2 text-red-600 hover:bg-red-50">
                            <x-lucide-trash class="w-4 h-4" /> Delete</button>
                    </form>
                </div>
            </div>
        @endif

    </div>

    <div class="flex flex-col gap-2">
        <div class="flex flex-col">
            <h2 class="font-bold text-amber-900">{{ $coffee->title ?? 'Coffee' }}</h2>
            <h4 class="text-amber-800">{{ $coffee->desc }}</h4>

        </div>

        @if (!empty($coffee->img_url))
            <div
                class="flex-shrink-0 max-w-[20rem] max-h-[20rem] rounded-md overflow-hidden border bg-white flex items-center justify-center">
                <img src="{{ Storage::disk('s3')->url($coffee->img_url) }}" alt="Coffee image"
                    class="object-contain w-full h-full" />
            </div>
        @endif
    </div>

    <div class="flex gap-2 justify-between items-end mt-2">
        <x-chip color="bg-amber-600" label="{{ config('app.coffee.types.' . ($coffee->type ?? 'espresso')) }}" />
        <span
            class="ml-auto text-xs bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full font-medium flex items-center gap-1">
            <x-lucide-clock class="w-4 h-4 inline-block mr-1 text-slate-400" />
            <span class="local-coffee-time" data-iso="{{ $coffee->consumed_at }}"></span>
        </span>
    </div>

    <div class="my-2 px-4 flex-1">
        <div class="w-full border-t border-slate-200"></div>
    </div>

    <x-comment-list :comments="$coffee->comments" />

    <form method="POST" action="{{ route(name: 'comment.create') }}" class="w-full flex gap-2 items-center">
        @csrf
        <input type="hidden" name="coffee_id" value="{{ $coffee->id }}">
        <input class="flex-1 p-2 px-4 border-1 border-slate-200 rounded-md text-md" name="content" type="text"
            required minlength="1" maxlength="255" placeholder="Add a comment">
        <button type="submit">
            <x-lucide-reply
                class="w-6 h-6 text-slate-800 transition-all hover:text-slate-900 hover:cursor-pointer hover:rotate-3" />
        </button>
    </form>
</div>
