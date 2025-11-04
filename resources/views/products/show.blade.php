<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- 
                MODIFIKASI:
                Tambahkan blok notifikasi 'success' (pop-up) di sini.
            -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Grid untuk layout detail -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <!-- Kolom Gambar -->
                        <div>
                            <!-- 
                                MODIFIKASI: 
                                Gunakan Storage::url() untuk menampilkan gambar
                            -->
                            <img src="{{ $product->image_url ? Storage::url($product->image_url) : 'https://placehold.co/600x400/e2e8f0/cccccc?text=Gambar+Produk' }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-auto object-cover rounded-lg shadow-md border border-gray-200">
                        </div>

                        <!-- Kolom Detail & Form -->
                        <div class="flex flex-col justify-between">
                            <div>
                                <!-- Kategori -->
                                <span class="text-sm font-semibold text-indigo-600 bg-indigo-100 px-3 py-1 rounded-full">
                                    {{ $product->category->name ?? 'Tidak Berkategori' }}
                                </span>

                                <!-- Nama Produk -->
                                <h1 class="text-3xl font-bold text-gray-800 mt-3 mb-2">
                                    {{ $product->name }}
                                </h1>

                                <!-- Harga -->
                                <p class="text-4xl font-extrabold text-gray-900 mb-4">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>

                                <!-- Deskripsi -->
                                <div class="prose max-w-none text-gray-600 mb-6">
                                    <p>{{ $product->description }}</p>
                                </div>
                            </div>

                            <!-- Form Add to Cart -->
                            <div>
                                <!-- 
                                    MODIFIKASI: 
                                    Tampilkan Stok (Quantity)
                                -->
                                <div class="mb-4">
                                    <span class="text-sm font-medium text-gray-700">
                                        Stok Tersisa: 
                                        <span class="font-bold {{ $product->quantity > 10 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $product->quantity }}
                                        </span>
                                    </span>
                                </div>

                                <!-- Cek jika stok ada -->
                                @if ($product->quantity > 0)
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        
                                        <div class="flex items-center gap-4 mb-4">
                                            <!-- Input Jumlah -->
                                            <div>
                                                <x-input-label for="quantity" :value="__('Jumlah')" class="sr-only" />
                                                <x-text-input id="quantity" class="block w-24 text-center" 
                                                              type="number" 
                                                              name="quantity" 
                                                              value="1" 
                                                              min="1" 
                                                              max="{{ $product->quantity }}" 
                                                              required />
                                            </div>
                                            
                                            <!-- Tombol Add to Cart -->
                                            <x-primary-button class="w-full justify-center text-base py-3">
                                                {{ __('+ Tambah ke Keranjang') }}
                                            </x-primary-button>
                                        </div>
                                    </form>
                                @else
                                    <!-- Tampilan jika stok habis -->
                                    <div class="p-4 text-center bg-red-100 border border-red-400 text-red-700 rounded-lg">
                                        <p class="font-bold">Stok Habis</p>
                                        <p class="text-sm">Produk ini tidak tersedia saat ini.</p>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

