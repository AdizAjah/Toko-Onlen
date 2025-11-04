<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- 
            MODIFIKASI: 
            - Menambahkan 'px-4' untuk padding horizontal di layar mobile 
        -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            

            <!-- Box Konten Atas (Filter) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <!-- 
                    MODIFIKASI: 
                    - Padding 'p-4' di mobile, 'sm:p-6' di layar lebih besar
                -->
                <div class="p-4 sm:p-6 text-gray-900">

                    <!-- Notifikasi Sukses (jika ada) -->
                    @if (session('success'))
                        <div class="mb-6 font-medium text-sm text-green-600 bg-green-100 border border-green-300 rounded-md p-4 shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- FORM FILTER UTAMA -->
                    <!-- MODIFIKASI RESPONSIF: 'space-y-4 sm:space-y-6' -->
                    <form action="{{ route('dashboard') }}" method="GET" class="space-y-4 sm:space-y-6">
                        <!-- Bawa parameter kategori jika ada -->
                        @if($selectedCategory)
                            <input type="hidden" name="category_id" value="{{ $selectedCategory }}">
                        @endif
                        
                        <!-- Search Bar -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Cari Produk</label>
                            <input type="text" name="search" id="search" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   placeholder="Nama produk, deskripsi..."
                                   value="{{ $search ?? '' }}">
                        </div>

                        <!-- Filter Harga -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="min_price" class="block text-sm font-medium text-gray-700">Harga Min (Rp)</label>
                                <input type="number" name="min_price" id="min_price"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       placeholder="0"
                                       value="{{ $minPrice ?? '' }}">
                            </div>
                            <div>
                                <label for="max_price" class="block text-sm font-medium text-gray-700">Harga Max (Rp)</label>
                                <input type="number" name="max_price" id="max_price"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       placeholder="1000000"
                                       value="{{ $maxPrice ?? '' }}">
                            </div>
                        </div>
                        
                        <!-- Tombol Submit Form -->
                        <div class="flex items-center justify-end space-x-4">
                            <!-- MODIFIKASI: Ganti hover:text-gray-900 menjadi hover:text-indigo-600 -->
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                                Reset Filter
                            </a>
                            <!-- Tombol ini akan otomatis menjadi Indigo dari component primary-button -->
                            <x-primary-button>
                                Terapkan Filter
                            </x-primary-button>
                        </div>
                    </form>

                    <hr class="my-6 border-gray-200">

                    <!-- Filter Kategori -->
                    <h3 class="text-lg sm:text-xl font-semibold mb-4">Telusuri Kategori</h3>
                    <!-- MODIFIKASI RESPONSIF: 'gap-2' -->
                    <div class="flex flex-wrap gap-2">
                        
                        <!-- Tombol "Semua Kategori" -->
                        @php
                            $queryAll = request()->query(); // Ambil query string saat ini
                            unset($queryAll['category_id']); // Hapus filter kategori
                        @endphp
                        <!-- MODIFIKASI RESPONSIF: padding 'px-3 py-1.5 text-xs' dan 'sm:px-4 sm:py-2 sm:text-sm' -->
                        <!-- Style ini sudah bagus dan konsisten dengan palet Indigo -->
                        <a href="{{ route('dashboard', $queryAll) }}" 
                           class="px-3 py-1.5 text-xs sm:px-4 sm:py-2 sm:text-sm rounded-lg font-medium transition-colors duration-150
                                  {{ !$selectedCategory ? 
                                     'bg-indigo-600 text-white shadow' : 
                                     'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Semua
                        </a>

                        <!-- Loop Kategori -->
                        @foreach ($categories as $category)
                            <!-- MODIFIKASI RESPONSIF: padding 'px-3 py-1.5 text-xs' dan 'sm:px-4 sm:py-2 sm:text-sm' -->
                            <a href="{{ route('dashboard', array_merge(request()->query(), ['category_id' => $category->id])) }}"
                               class="px-3 py-1.5 text-xs sm:px-4 sm:py-2 sm:text-sm rounded-lg font-medium transition-colors duration-150
                                      {{ $selectedCategory == $category->id ? 
                                         'bg-indigo-600 text-white shadow' : 
                                         'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Judul "Produk Kami" -->
            <h3 class="text-xl sm:text-2xl font-semibold mb-4 text-gray-800">
                @if ($selectedCategory)
                    Menampilkan Produk: {{ $categories->find($selectedCategory)->name }}
                @elseif ($search)
                    Hasil Pencarian untuk: "{{ $search }}"
                @else
                    Semua Produk
                @endif
            </h3>

            <!-- Grid Produk -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @forelse ($products as $product)
                    <!-- MODIFIKASI: Menambahkan 'transition-all duration-300 hover:shadow-xl' untuk efek dinamis -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col relative group transition-all duration-300 hover:shadow-xl">
                        
                        <!-- Tanda Stok Habis -->
                        @if($product->quantity <= 0)
                            <span class="absolute top-2 right-2 sm:top-3 sm:right-3 z-20 bg-red-600 text-white text-[10px] px-2 py-0.5 sm:text-xs sm:px-3 sm:py-1 rounded-full uppercase font-semibold">
                                Stok Habis
                            </span>
                        @endif
                        
                        <!-- Link Utama (Latar Belakang) -->
                        <a href="{{ route('products.show', $product) }}" class="absolute inset-0 z-10" aria-label="Lihat {{ $product->name }}"></a>

                        <!-- Gambar Produk -->
                        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden">
                            <img src="{{ $product->image_url ? Storage::url($product->image_url) : 'https://placehold.co/600x400/e2e8f0/cccccc?text=Produk' }}"
                                 alt="{{ $product->name }}"
                                 class="h-full w-full object-cover object-center transition-transform duration-300 group-hover:scale-105
                                        @if($product->quantity <= 0) opacity-60 @endif">
                        </div>

                        <!-- Detail Produk -->
                        <div class="p-3 sm:p-4 flex flex-col flex-grow">
                            <!-- MODIFIKASI: Mengganti text-gray-500 menjadi text-indigo-600 dan font-medium -->
                            <h3 class="text-xs sm:text-sm font-medium text-indigo-600 mb-1">
                                {{ $product->category->name ?? 'Tanpa Kategori' }}
                            </h3>
                            <h4 class="text-sm sm:text-md font-semibold text-gray-900 truncate">
                                {{ $product->name }}
                            </h4>
                            <p class="mt-2 text-base sm:text-lg font-bold text-gray-900">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            
                            <!-- TAMPILAN STOK BARU -->
                            <p class="mt-1 sm:mt-2 text-xs font-medium {{ $product->quantity > 10 ? 'text-green-600' : 'text-yellow-600' }}">
                                @if($product->quantity > 0)
                                    Stok Tersisa: {{ $product->quantity }}
                                @else
                                    <!-- (Badge "Stok Habis" sudah menutupi ini) -->
                                @endif
                            </p>
                        </div>
                    </div>
                @empty
                    <!-- Jika Produk Kosong -->
                    <div class="col-span-full bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500">
                            <p>Tidak ada produk yang cocok dengan filter Anda.</p>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
