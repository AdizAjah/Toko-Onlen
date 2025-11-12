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
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!-- 
            MODIFIKASI: 
            - Tetap menggunakan bg-gray-50 (konsisten dengan app.css Anda)
            - Mengganti warna logo menjadi text-indigo-600
            - Membuat kartu login lebih modern (shadow-xl, rounded-lg, padding lebih besar)
            - Menambahkan px-4 untuk padding di layar kecil
        -->
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50 px-4">
            <div>
                <a href="/">
                    <!-- MODIFIKASI: Ubah text-gray-500 menjadi text-indigo-600 agar sesuai tema -->
                    <x-application-logo class="w-20 h-20 fill-current text-indigo-600" />
                </a>
            </div>

            <!-- MODIFIKASI: Ganti shadow-md, py-4, sm:rounded-lg menjadi shadow-xl, py-8, rounded-lg -->
            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-xl overflow-hidden rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
