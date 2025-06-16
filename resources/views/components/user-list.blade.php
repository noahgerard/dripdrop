@props(['users', 'show_department' => false])

@php
    use Carbon\Carbon;
@endphp

<div class="flex flex-col gap-2 bg-white rounded-2xl shadow-lg p-2 sm:p-4">
    @forelse ($users as $user)
        <div class="flex items-center gap-4 p-3 rounded-lg bg-gray-50 shadow-sm hover:bg-yellow-50 transition">
            <span class="inline-block w-2 h-2 rounded-full bg-red-400"></span>
            <a href="{{ route('user.view', ['id' => $user->id]) }}" class="font-semibold text-gray-800 hover:underline">
                {{ $user->name }}

                @if ($show_department)
                    [{{ $user->department->name }}]
                @endif
            </a>

            <div class="flex gap-2">
                @if ($user->id == Auth::user()->id)
                    <x-chip color="bg-green-600" label="You" />
                @endif

                @if (Carbon::createFromDate($user->created_at)->diffInHours() <= 48)
                    <x-chip color="bg-red-600" label="NEW" />
                @endif
            </div>

            <span class="text-gray-500 text-sm ml-auto">{{ $user->coffees_count ?? ($user->coffees->count() ?? 0) }}
                coffees</span>
        </div>
    @empty
        <div class="text-gray-400 text-center py-4">No members yet.</div>
    @endforelse
</div>
