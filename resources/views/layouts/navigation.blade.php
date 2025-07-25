<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                {{-- <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link class="flex items-center gap-2" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <x-lucide-house class="w-5 h-5" /> Home
                    </x-nav-link>

                    <x-nav-link class="flex items-center gap-2" :href="route('leaderboard')" :active="request()->routeIs('leaderboard')">
                        <x-lucide-trophy class="w-5 h-5" /> Leaderboard
                    </x-nav-link>

                    <x-nav-link class="flex items-center gap-2" :href="route('coffee.form')" :active="request()->routeIs('coffee')">
                        <x-lucide-coffee class="w-5 h-5" /> Log
                    </x-nav-link>

                    @auth
                        <x-nav-link class="flex items-center gap-2" :href="route('feed.view')" :active="request()->routeIs('feed')">
                            <x-lucide-newspaper class="w-5 h-5" /> Feed
                        </x-nav-link>
                    @endauth
                </div> --}}
            </div>

            {{-- Floating Navigation Bar --}}
            <x-floating-nav />

            <!-- Drink Coffee button -->
            {{-- @auth
                <form method="POST" class="flex items-center" action="{{ route('coffee.create') }}" id="coffee-form">
                    @csrf
                    <button type="submit" id="coffee-btn"
                        class="bg-red-400 flex items-center gap-2 p-2 h-fit text-white font-bold hover:cursor-pointer transition-transform hover:scale-y-95 hover:scale-x-105">
                        I drinked coffee <x-lucide-coffee class="w-5" />
                    </button>
                </form>
            @endauth --}}

            <!-- Settings Dropdown -->
            @auth
                <div class="hidden sm:flex sm:items-center sm:ms-6 gap-2">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">

                                <div class="mr-2">
                                    <img src={{ Auth::user()->avatar() }} class="w-10 h-10 rounded-full"
                                        alt="Profile Picture">
                                </div>

                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>

                    <x-notif-pill />
                </div>
            @endauth

            @guest
                <button class="hidden sm:block text-sm flex items-center gap-2"><a href="/register"><x-lucide-rocket
                            class="w-5 h-5" /> Get Started</a></button>
            @endguest


            <!-- Hamburger -->
            <div class="-me-2 flex gap-2 items-center sm:hidden">
                <x-notif-pill />

                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            {{-- <x-responsive-nav-link class="flex items-center gap-2" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <x-lucide-house class="w-5 h-5" /> Dashboard
            </x-responsive-nav-link>

            <x-responsive-nav-link class="flex items-center gap-2" :href="route('leaderboard')" :active="request()->routeIs('leaderboard')">
                <x-lucide-trophy class="w-5 h-5" /> Leaderboard
            </x-responsive-nav-link>

            <x-responsive-nav-link class="flex items-center gap-2" :href="route('coffee.form')" :active="request()->routeIs('coffee')">
                <x-lucide-coffee class="w-5 h-5" /> Log
            </x-responsive-nav-link>

            @auth
                <x-responsive-nav-link class="flex items-center gap-2" :href="route('feed.view')" :active="request()->routeIs('feed')">
                    <x-lucide-newspaper class="w-5 h-5" /> Feed
                </x-responsive-nav-link>
            @endauth --}}

            @guest
                <x-responsive-nav-link class="flex items-center gap-2" :href="route('register')">
                    <x-lucide-rocket class="w-5 h-5" /> Get Started
                </x-responsive-nav-link>
            @endguest
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>


                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link class="flex items-center gap-2" :href="route('profile.edit')">
                        <x-lucide-user class="w-5 h-5" /> Profile
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link class="flex items-center gap-2" :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            <x-lucide-log-out class="w-5 h-5" /> Log Out
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
