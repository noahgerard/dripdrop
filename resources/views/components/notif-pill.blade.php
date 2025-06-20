<!-- Notification Pill Icon (only show if unreadCount > 0) -->
@auth
    @php
        $unreadCount = Auth::user()->notifications()->whereNull('read_at')->count();
    @endphp
    @if ($unreadCount > 0)
        <a href="{{ route('notifications.index') }}" class="relative group flex items-center">
            <span
                class="ml-2 bg-red-500 text-white text-xs rounded-full px-2 py-0.5 font-bold animate-pulse flex items-center min-w-[1.5rem] justify-center">
                {{ $unreadCount }}
            </span>
        </a>
    @endif
@endauth
