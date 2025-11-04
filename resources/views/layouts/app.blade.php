<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <!-- Font 'Figtree' diganti oleh 'Inter' yang diimpor di app.css -->

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Perbaikan FOUC (Flash of Unstyled Content) untuk Alpine.js -->
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <!-- 
            MODIFIKASI: 
            Mengganti 'bg-gray-100' menjadi 'bg-gray-50' agar sesuai dengan app.css
        -->
        <div class="min-h-screen bg-gray-50">
            
            <div class="sticky top-0 z-50">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif
            </div>

            <!-- Page Content -->
            <main class="pb-20 sm:pb-0">
                {{ $slot }}
            </main>

            <!-- 
                MODIFIKASI: 
                Mengubah footer agar lebih bersih dan konsisten
            -->
            <footer class="hidden sm:block bg-gray-50 border-t border-gray-200">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Toko Onlen') }}. Hak Cipta Dilindungi.
                </div>
            </footer>

            <!-- Bottom Navigation (Mobile Only) -->
            <nav class="sm:hidden fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-gray-200 shadow-[0_-2px_5px_rgba(0,0,0,0.05)]">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="flex justify-around h-16 items-center">
                        
                        <!-- 
                            MODIFIKASI: 
                            - Menambahkan 'transition-colors duration-200'
                            - Mengganti 'text-indigo-600' (jika aktif) dan 'text-gray-500 hover:text-gray-700' (jika non-aktif)
                            - Ini berlaku untuk semua link di navigasi bawah
                        -->

                        <!-- Link Dashboard -->
                        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center text-center px-3 transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-gray-500 hover:text-indigo-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6-4a1 1 0 001-1v-1a1 1 0 10-2 0v1a1 1 0 001 1zm5 0a1 1 0 001-1v-1a1 1 0 10-2 0v1a1 1 0 001 1z" />
                            </svg>
                            <span class="text-xs font-medium">Home</span>
                        </a>
                        
                        <!-- Link Keranjang (Hanya User) -->
                        @if(Auth::user()->role == 'user')
                        <a href="{{ route('cart.index') }}" class="flex flex-col items-center justify-center text-center px-3 transition-colors duration-200 {{ request()->routeIs('cart.index') ? 'text-indigo-600' : 'text-gray-500 hover:text-indigo-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="text-xs font-medium">Keranjang</span>
                        </a>
                        @endif

                        <!-- Link Profile -->
                        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center text-center px-3 transition-colors duration-200 {{ request()->routeIs('profile.edit') ? 'text-indigo-600' : 'text-gray-500 hover:text-indigo-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-xs font-medium">Profile</span>
                        </a>

                        <!-- Link Admin (Hanya Admin) -->
                        @if(Auth::check() && Auth::user()->role == 'admin')
                            <!-- Link Kelola Produk -->
                            <a href="{{ route('admin.products.index') }}" class="flex flex-col items-center justify-center text-center px-3 transition-colors duration-200 {{ request()->routeIs('admin.products.*') ? 'text-indigo-600' : 'text-gray-500 hover:text-indigo-600' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <span class="text-xs font-medium">Produk</span>
                            </a>
                            <!-- Link Kelola Kategori -->
                            <a href="{{ route('admin.categories.index') }}" class="flex flex-col items-center justify-center text-center px-3 transition-colors duration-200 {{ request()->routeIs('admin.categories.*') ? 'text-indigo-600' : 'text-gray-500 hover:text-indigo-600' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-5 5a2 2 0 01-2.828 0l-7-7A2 2 0 013 8V5a2 2 0 012-2z" />
                                </svg>
                                <span class="text-xs font-medium">Kategori</span>
                            </a>
                        @endif
                    </div>
                </div>
            </nav>
        </div>
    </body>
</html>
