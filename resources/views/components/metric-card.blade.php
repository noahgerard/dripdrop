@props(['value', 'label'])

<div
    class="transition-all group flex flex-col items-center nowrap justify-center bg-white rounded-2xl shadow-lg px-2 sm:px-8 py-4 sm:py-6 flex-1 min-w-[40%] sm:min-w-fit">
    <h2 class="group-hover:text-green-700 group-hover:rotate-3 text-3xl whitespace-nowrap md:text-5xl font-extrabold text-gray-800 mb-2">{{ $value }}</h2>
    <h4 class="text-lg whitespace-nowrap text-gray-500 text-center">{{ $label }}</h4>
</div>
