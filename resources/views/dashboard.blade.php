<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Cek Role User -->
            @if(Auth::user()->role == 'admin')
                <!-- TAMPILAN UNTUK ADMIN -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ __("Anda login sebagai Admin.") }} <br>
                        Silakan gunakan menu "Kelola Produk" di navigasi untuk mengatur barang.
                    </div>
                </div>
            @else
                <!-- TAMPILAN UNTUK USER (DAFTAR PRODUK) -->
                
                <!-- Notifikasi Sukses (jika redirect dari halaman lain) -->
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse ($products as $product)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col">
                            <!-- Gambar Produk (Placeholder jika tidak ada URL) -->
                            <img src="{{ $product->image_url ?? 'https://placehold.co/600x400/EEE/31343C?text=Produk' }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                            
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-semibold text-lg text-gray-900">{{ $product->name }}</h3>
                                <p class="text-gray-600 text-sm mt-1 flex-grow">{{ $product->description }}</p>
                                <p class="text-lg font-bold text-gray-900 mt-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                                <!-- Form Tombol Add to Cart -->
                                <form action="{{ route('cart.store') }}" method="POST" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        + Keranjang
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-gray-500">
                            Belum ada produk yang tersedia saat ini.
                        </div>
                    @endforelse
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
