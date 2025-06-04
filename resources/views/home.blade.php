<x-app-layout>
    <main class="h-full py-20 flex flex-col">
        <div class="flex-1 flex justify-center">
            <div>
                <h1 class="font-bold text-5xl">DripDrop</h1>
                <h3>The DSC Coffee Tracker</h3>
            </div>
        </div>
    </main>

    {{-- @php
        use App\Models\Department;
        $departments = Department::all();
    @endphp
    <ul>
        @foreach ($departments as $department)
            <marquee class="p-4 bg-red-500 rounded-md">{{ $department->name }}</marquee>
        @endforeach
    </ul> --}}
</x-app-layout>
