@props(['active'])

@php
    $classes = $active ?? false ? 'text-blue-600' : 'text-slate-600';
    $base = ' flex items-center gap-2  ';
@endphp

<a {{ $attributes->merge(['class' => $base . $classes]) }}>
    <span class="hover:-translate-y-1 hover:text-blue-600 transition-all">
        {{ $slot }}
    </span>
</a>
