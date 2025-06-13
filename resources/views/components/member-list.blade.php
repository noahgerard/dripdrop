<div class="flex flex-col gap-2">
    @foreach ($members as $member)
        <a href="{{ route('user.view', ['id' => $member->id]) }}"
            class="flex items-center gap-2 p-2 rounded hover:bg-yellow-50">
            <span class="font-semibold text-gray-800">{{ $member->name }}</span>
            <span class="text-gray-500 text-xs">({{ $member->email }})</span>
        </a>
    @endforeach
</div>
