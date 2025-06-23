<div class="fixed flex justify-center w-full left-0 bottom-[5%] z-50 pointer-events-none">
    <div
        class="flex gap-8 p-4 px-10 rounded-full shadow-2xl bg-gradient-to-r from-white/60 via-slate-100/60 to-white/60 backdrop-blur-xl border-2 border-white/20 pointer-events-auto">
        <x-nav-icon :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <x-lucide-house class="w-7 h-7" />
        </x-nav-icon>

        <x-nav-icon :href="route('leaderboard')" :active="request()->routeIs('leaderboard')">
            <x-lucide-trophy class="w-7 h-7" />
        </x-nav-icon>

        <x-nav-icon :href="route('coffee.form')" :active="request()->routeIs('coffee')">
            <x-lucide-coffee class="w-7 h-7" />
        </x-nav-icon>

        @auth
            <x-nav-icon :href="route('feed.view')" :active="request()->routeIs('feed')">
                <x-lucide-newspaper class="w-7 h-7" />
            </x-nav-icon>
        @endauth
    </div>
</div>
