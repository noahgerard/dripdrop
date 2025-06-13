@props(['label', 'color' => 'bg-green-600'])

<div class="flex justify-center items-center px-2 py-0.5 text-xs rounded-md {{ $color }} text-white font-bold">
    {{ ucfirst($label) }}
</div>
