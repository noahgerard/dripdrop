@props(['icon_name', 'word', 'title', 'description', 'image' => ''])

<div class="group relative flex-1 bg-red-500 text-white py-12 md:py-24 px-8">

    <img class="absolute inset-0 w-full h-full object-cover" src="{{ $image }}" />
    <div class="absolute inset-0 w-full h-full bg-blue-500 group-hover:bg-blue-800 transition-all group-hover:opacity-60 opacity-40"></div>
    <div
        class="flex flex-col gap-2 justify-center items-center transition-all duration-300 -translate-y-2 sm:translate-y-6 group-hover:-translate-y-5">
        <x-dynamic-component :component="$icon_name"
            class="text-white w-[2rem] sm:w-[3rem] transition-all duration-300 group-hover:scale-90" />
        <p class="font-extrabold text-white text-3xl sm:text-5xl transition-all duration-250 group-hover:scale-75">
            {{ $word }}
        </p>
        <div class="text-center transition-all duration-500 md:opacity-0 group-hover:opacity-100 scale-80 group-hover:scale-100">
            <p class="font-bold">{{ $title }}</p>

            <p class="hidden md:block">{{ $description }}
            </p>
        </div>
    </div>
</div>
