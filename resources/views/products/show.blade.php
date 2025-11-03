<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Notifikasi Sukses (jika ada) -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-300 text-green-600 px-4 py-3 rounded-md shadow-sm" role="alert">
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif
            <!-- Notifikasi Error (jika ada) -->
            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-300 text-red-600 px-4 py-3 rounded-md shadow-sm" role="alert">
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 md:grid md:grid-cols-2 md:gap-12">
                    
                    <!-- Sisi Kiri: Gambar Produk -->
                    <div class="mb-6 md:mb-0">
                        <img src="{{ $product->image_url ?? 'https://placehold.co/600x400/EEE/31343C?text=Produk' }}"
                             alt="{{ $product->name }}"
                             class="w-full h-auto object-cover rounded-lg shadow-md">
                    </div>

                    <!-- Sisi Kanan: Detail & Form Keranjang -->
                    <div class="flex flex-col justify-between">
                        <div>
                            <!-- Kategori -->
                            <span class="text-sm font-semibold text-indigo-600 uppercase">
                                {{ $product->category->name ?? 'Tanpa Kategori' }}
                            </span>
                            
                            <!-- Nama Produk -->
                            <h1 class="text-3xl font-bold text-gray-900 mt-2 mb-3">
                                {{ $product->name }}
                            </h1>
                            
                            <!-- Harga -->
                            <p class="text-4xl font-extrabold text-gray-800 mb-4">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            
                            <!-- Deskripsi -->
                            <p class="text-gray-700 leading-relaxed mb-6">
                                {{ $product->description ?? 'Deskripsi produk tidak tersedia.' }}
                            </p>

                            <!-- ===== TAMPILAN STOK BARU ===== -->
                            <div class="mb-6">
                                @if($product->quantity > 10)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-500" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Stok Tersedia ({{ $product->quantity }})
                                    </span>
                                @elseif($product->quantity > 0)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-yellow-500" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Stok Hampir Habis (Sisa {{ $product->quantity }})
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-red-500" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Stok Habis
                                    </span>
                                @endif
                            </div>
                            <!-- ===== AKHIR TAMPILAN STOK ===== -->
                        </div>

                        <!-- Form Tambah Keranjang -->
                        @if($product->quantity > 0)
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <div class="flex items-center gap-4">
                                    <!-- Input Jumlah -->
                                    <div>
                                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->quantity }}" 
                                               class="w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    
                                    <!-- Tombol Submit -->
                                    <button type="submit" 
                                            class="flex-1 mt-6 px-8 py-3 bg-indigo-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Tambah ke Keranjang
                                    </button>
                                </div>
                                <!-- Info max stok -->
                                <p class="text-xs text-gray-500 mt-2 ml-1">Maks. pembelian: {{ $product->quantity }} unit.</p>
                            </form>
                        @else
                            <!-- Tampilan jika stok habis -->
                            <div class="mt-6">
                                <button type="button" 
                                        disabled
                                        class="flex-1 w-full px-8 py-3 bg-gray-300 text-gray-500 text-base font-medium rounded-md shadow-sm cursor-not-allowed">
                                    Stok Habis
                                </button>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            <!-- Tombol Kembali -->
            <div class="mt-8">
                <a href="{{ url()->previous() }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                    &larr; Kembali ke Daftar Produk
                </a>
            </div>

        </div>
    </div>
</x-app-layout>

