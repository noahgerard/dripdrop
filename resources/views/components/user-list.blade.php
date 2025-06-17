@props(['users', 'show_department' => false])

@php
    use Carbon\Carbon;
@endphp

<div class="flex flex-col gap-2 bg-white rounded-2xl shadow-lg p-2 sm:p-4">
    @forelse ($users as $user)
        <div class="flex items-center gap-4 p-2 sm:p-3 rounded-lg bg-gray-50 shadow-sm hover:bg-yellow-50 transition">
            <span class="hidden sm:inline-block w-2 h-2 rounded-full bg-red-400"></span>

            <img src={{ $user->avatar() }} class="w-10 h-10 rounded-full" alt="Profile Picture"></img>

            <span class="font-semibold flex flex-col text-gray-800 max-w-md truncate">
                <a href="{{ route('user.view', parameters: ['id' => $user->id]) }}" class="hover:underline">
                    <h2 class="font-semibold">{{ $user->name }}</h2>
                </a>

                @if ($show_department)
                    <a href="{{ route('department.view', parameters: ['id' => $user->department->id]) }}"
                        class="hover:underline">
                        <h4 class="text-sm text-slate-500">{{ $user->department->name }}</h4>
                    </a>
                @endif
            </span>

            <div class="flex gap-2">
                @if ($user->id == Auth::user()->id)
                    <x-chip color="bg-green-600" label="You" />
                @endif

                @if (Carbon::createFromDate($user->created_at)->diffInHours() <= 48)
                    <x-chip color="bg-red-600" label="NEW" />
                @endif
            </div>

            <span
                class="text-gray-500 text-sm ml-auto text-nowrap">{{ $user->coffees_count ?? ($user->coffees->count() ?? 0) }}
                coffees</span>
        </div>
    @empty
        <div class="text-gray-400 text-center py-4">No members yet.</div>
    @endforelse
</div>
