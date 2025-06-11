@props(['name', 'show' => false, 'maxWidth' => '2xl'])

@php
    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ][$maxWidth];
@endphp

<div x-data="{
    show: @js($show),
    focusables() {
        let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])';
        return [...this.$root.querySelectorAll(selector)].filter(el => !el.hasAttribute('disabled'));
    },
    firstFocusable() { return this.focusables()[0] },
    lastFocusable() { return this.focusables().slice(-1)[0] },
    nextFocusable() {
        const i = this.focusables().indexOf(document.activeElement);
        return this.focusables()[(i + 1) % this.focusables().length] || this.firstFocusable();
    },
    prevFocusable() {
        const i = this.focusables().indexOf(document.activeElement);
        return this.focusables()[(i - 1 + this.focusables().length) % this.focusables().length] || this.lastFocusable();
    },
}" x-init="$watch('show', value => {
    if (value) {
        document.body.classList.add('overflow-y-hidden');
        {{ $attributes->has('focusable') ? 'setTimeout(() => firstFocusable().focus(), 100);' : '' }}
    } else {
        document.body.classList.remove('overflow-y-hidden');
    }
})" x-show="show" x-cloak
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null" x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-on:keydown.tab.prevent="$event.shiftKey ? prevFocusable().focus() : nextFocusable().focus()"
    class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6 sm:px-0" style="display: none;">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity z-40" x-show="show"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-on:click="show = false"></div>

    <!-- Modal -->
    <div x-show="show" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="relative z-50 bg-white rounded-lg shadow-xl overflow-hidden sm:w-full {{ $maxWidth }} sm:mx-auto">
        {{ $slot }}
    </div>
</div>
