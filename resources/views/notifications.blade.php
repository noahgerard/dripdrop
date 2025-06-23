<x-app-layout>

    <div class="container mx-auto max-w-2xl py-8 px-2">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Notifications</h1>
            @if ($notifications->whereNull('read_at')->count())
                <form method="POST" action="{{ route('notifications.markAllAsRead') }}">
                    @csrf
                    @method('PATCH')
                    <x-primary-button class="!py-1 !px-3 !text-xs">Mark all as read</x-primary-button>
                </form>
            @endif
        </div>
        <div class="bg-white shadow rounded-lg divide-y">
            @forelse($notifications as $notification)
                <div class="flex items-center px-4 py-4 {{ $notification->read_at ? '' : 'bg-blue-50' }}">
                    <div class="flex-1">
                        <div class="text-sm text-gray-800">
                            @if ($notification->type === 'comment')
                                <span
                                    class="font-semibold">{{ $notification->data['from_user_name'] ?? 'Someone' }}</span>
                                commented on your coffee post:
                                <a href="{{ route('coffee.view', ['id' => $notification->data['coffee_id'] ?? null]) }}"
                                    class="italic underline hover:text-blue-600">"{{ $notification->data['content'] ?? '' }}"</a>
                            @elseif ($notification->type === 'reminder')
                                {{ $notification->data['message'] }}
                            @endif
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                    </div>
                    @if (!$notification->read_at)
                        <form method="POST" action="{{ route('notifications.markAsRead', $notification) }}"
                            class="ml-4">
                            @csrf
                            @method('PATCH')
                            <x-secondary-button submit class="!py-1 !px-3 !text-xs">Mark as read</x-secondary-button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="px-4 py-8 text-center text-gray-500">
                    No notifications yet.
                </div>
            @endforelse
        </div>
        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    </div>
</x-app-layout>
