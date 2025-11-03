<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- 
                MODIFIKASI:
                Tambahkan kode ini untuk menangkap dan menampilkan "pop-up"
                notifikasi yang dikirim oleh CartController.
            -->
            @if (session('success'))
                <div class="mb-6 font-medium text-sm text-green-600 bg-green-100 border border-green-300 rounded-md p-4 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            <!-- Akhir Modifikasi -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <!-- Kolom Gambar -->
                        <div>
                            <img src="{{ $product->image_url ?? 'https://placehold.co/600x400/EEE/31343C?text=Produk' }}" alt="{{ $product->name }}" class="w-full h-auto object-cover rounded-lg shadow-md">
                        </div>

                        <!-- Kolom Detail dan Form -->
                        <div>
                            <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
                            
                            <p class="text-3xl font-semibold text-gray-800 mb-4">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>

                            <p class="text-gray-600 mb-6">
                                {{ $product->description }}
                            </p>

                            <!-- Form Tombol Add to Cart -->
                            <form action="{{ route('cart.store') }}" method="POST" class="mt-4">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <!-- Input Jumlah -->
                                <div class="mb-3">
                                    <label for="quantity-{{ $product->id }}" class="block text-sm font-medium text-gray-700">Jumlah</label>
                                    <input type="number" id="quantity-{{ $product->id }}" name="quantity" value="1" min="1" class="mt-1 block w-full max-w-xs border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                </div>
                                
                                <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    + Tambah ke Keranjang
                                </button>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
