<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full bg-slate-100">
    <nav class="w-full flex justify-center gap-4 p-2 fixed">
        <a href="/">Home</a>
        <a href="/leaderboard">Leaderboard</a>
    </nav>
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
</body>

</html>
