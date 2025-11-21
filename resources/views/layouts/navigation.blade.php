<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- Link Keranjang (Hanya untuk User) -->
                    @auth
                    @if(Auth::user()->role == 'user')
                    <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                        {{ __('Keranjang') }}
                    </x-nav-link>
                    @endif
                    @endauth

                    <!-- Link Admin (Hanya untuk Admin) -->
                    @auth
                    @if(Auth::user()->role == 'admin')
                    <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                        {{ __('Kelola Produk') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                        {{ __('Kelola Kategori') }}
                    </x-nav-link>
                    @endif
                    @endauth

                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                        {{ __('About Us') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Search Bar (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:flex-1 sm:max-w-md sm:mx-4">
                <form action="{{ route('dashboard') }}" method="GET" class="w-full">
                    @if(request('category_id'))
                    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                    @endif
                    @if(request('brand'))
                    <input type="hidden" name="brand" value="{{ request('brand') }}">
                    @endif
                    @if(request('min_price'))
                    <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                    @endif
                    @if(request('max_price'))
                    <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                    @endif
                    <div class="relative">
                        <input type="text"
                            name="search"
                            placeholder="Cari produk..."
                            value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-2 text-sm border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Settings Dropdown (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
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
                @else
                <div class="space-x-4">
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900">Log in</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-sm text-gray-700 hover:text-gray-900">Register</a>
                    @endif
                </div>
                @endauth
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Search Bar (Mobile - Below Main Nav) -->
        <div class="sm:hidden px-4 pb-3">
            <form action="{{ route('dashboard') }}" method="GET">
                @if(request('category_id'))
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                @endif
                @if(request('brand'))
                <input type="hidden" name="brand" value="{{ request('brand') }}">
                @endif
                @if(request('min_price'))
                <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                @endif
                @if(request('max_price'))
                <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                @endif
                <div class="relative">
                    <input type="text"
                        name="search"
                        placeholder="Cari produk..."
                        value="{{ request('search') }}"
                        class="w-full pl-10 pr-4 py-2 text-sm border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- 
        MODIFIKASI DIMULAI DI SINI:
        Menu dropdown responsif lama dihapus dan diganti dengan 
        logika Overlay + Slide-in Panel 
    -->

    <!-- Mobile Menu (Slide-in) & Overlay -->

    <!-- Overlay Gelap (muncul saat 'open = true') -->
    <div x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="open = false"
        class="fixed inset-0 z-40 bg-black/50 sm:hidden"
        x-cloak>
    </div>

    <!-- Panel Slide-in (muncul dari kiri saat 'open = true') -->
    <div x-show="open"
        x-transition:enter="transform transition ease-in-out duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed top-0 left-0 bottom-0 z-50 w-72 bg-white shadow-lg overflow-y-auto sm:hidden"
        @click.outside="open = false"
        x-cloak>

        <!-- Logo/Header di dalam menu -->
        <div class="p-4 border-b flex justify-between items-center">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
            </a>
            <!-- Tombol Close di dalam panel -->
            <button @click="open = false" class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Link Navigasi (Mobile) -->
        <div class="pt-4 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <!-- Link Keranjang (Hanya untuk User) -->
            @auth
            @if(Auth::user()->role == 'user')
            <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                {{ __('Keranjang') }}
            </x-responsive-nav-link>
            @endif
            @endauth

            <!-- Link Admin (Hanya untuk Admin) -->
            @auth
            @if(Auth::user()->role == 'admin')
            <div class="border-t border-gray-200 pt-4 mt-4">
                <div class="px-4">
                    <div class="font-medium text-sm text-gray-500 uppercase">{{ __('Menu Admin') }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                        {{ __('Kelola Produk') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                        {{ __('Kelola Kategori') }}
                    </x-responsive-nav-link>
                </div>
            </div>
            @endif
            @endauth
        </div>

        <!-- User Info & Logout (Mobile) -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                            this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            @else
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Log in') }}
                </x-responsive-nav-link>
                @if (Route::has('register'))
                <x-responsive-nav-link :href="route('register')">
                    {{ __('Register') }}
                </x-responsive-nav-link>
                @endif
            </div>
            @endauth
        </div>
    </div>
    <!-- MODIFIKASI SELESAI -->

</nav>