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

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- === TAMBAHKAN LINK ADMIN DI SINI === -->
                    @if(Auth::user()->role == 'admin')
                    <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                        {{ __('Kelola Produk') }}
                    </x-nav-link>
                    @endif
                    <!-- === AKHIR LINK ADMIN === -->

                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- ... (Kode dropdown user yang sudah ada) ... -->
<!-- ... existing code ... -->
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <!-- ... (Kode hamburger menu yang sudah ada) ... -->
<!-- ... existing code ... -->
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

             <!-- === TAMBAHKAN LINK ADMIN DI SINI (VERSI RESPONSIVE) === -->
             @if(Auth::user()->role == 'admin')
             <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                {{ __('Kelola Produk') }}
            </x-responsive-nav-link>
             @endif
             <!-- === AKHIR LINK ADMIN === -->
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <!-- ... (Kode responsive settings yang sudah ada) ... -->
<!-- ... existing code ... -->
        </div>
    </div>
</nav>
