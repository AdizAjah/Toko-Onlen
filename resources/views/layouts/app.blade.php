<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts (Asumsi dari Breeze) -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts (Asumsi dari Breeze, jika Anda menjalankan 'npm run dev') -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- <!-- Jika Anda tidak menjalankan 'npm run dev', hapus @vite di atas dan gunakan ini: --> --}}
        <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    </head>
    <body class="font-sans antialiased">
        <!-- 
          Kita membungkus 'min-h-screen' di dalam flex column 
          agar footer bisa menempel di bawah jika kontennya pendek 
        -->
        <div class="flex flex-col min-h-screen bg-gray-100">
            
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content (flex-grow membuat konten mengisi ruang) -->
            <main class="flex-grow">
                {{ $slot }}
            </main>

            <!-- ===== FOOTER BARU ===== -->
            <!-- Footer ini akan muncul di SEMUA halaman -->
            <footer class="bg-white border-t border-gray-200 mt-12 shadow-inner-top">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 text-center text-gray-500">
                    <p>&copy; {{ date('Y') }} Toko Onlen. All rights reserved.</p>
                    <p class="text-sm mt-1">Dibuat dengan Laravel & Tailwind CSS</p>
                </div>
            </footer>
            <!-- ===== AKHIR FOOTER ===== -->

        </div>
    </body>
</html>
