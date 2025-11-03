<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Keranjang Belanja Anda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Notifikasi Sukses/Error -->
            @if (session('success'))
                <div class="mb-6 font-medium text-sm text-green-600 bg-green-100 border border-green-300 rounded-md p-4 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 font-medium text-sm text-red-600 bg-red-100 border border-red-300 rounded-md p-4 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    
                    @if($cartItems->isEmpty())
                        <!-- Tampilan Keranjang Kosong -->
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900">Keranjang Anda Kosong</h3>
                            <p class="mt-1 text-sm text-gray-500">Ayo mulai belanja dan tambahkan produk ke sini.</p>
                            <div class="mt-6">
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-indigo-700">
                                    Kembali ke Toko
                                </a>
                            </div>
                        </div>

                    @else
                        <!-- Tampilan Keranjang Isi -->

                        <!-- ================== TAMPILAN MOBILE (Hilang di Desktop) ================== -->
                        <div class="md:hidden">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Pesanan</h3>
                            <div class="space-y-4">
                                @foreach($cartItems as $item)
                                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200">
                                        <div class="flex items-center space-x-4">
                                            <!-- Gambar -->
                                            <div class="flex-shrink-0">
                                                <img src="{{ $item->product->image_url ?? 'https://placehold.co/100x100/EEE/31343C?text=Produk' }}"
                                                     alt="{{ $item->product->name }}" class="w-16 h-16 rounded-md object-cover">
                                            </div>
                                            <!-- Info Produk -->
                                            <div class="flex-1 min-w-0">
                                                <a href="{{ route('products.show', $item->product) }}" class="text-sm font-semibold text-gray-900 truncate hover:text-indigo-600">
                                                    {{ $item->product->name }}
                                                </a>
                                                <p class="text-sm text-gray-500">
                                                    {{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                                </p>
                                                <p class="text-sm font-medium text-gray-800 mt-1">
                                                    Subtotal: Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                        <!-- Tombol Hapus (Mobile) -->
                                        <div class="mt-3 text-right">
                                            <form action="{{ route('cart.destroy', $item) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-medium text-red-600 hover:text-red-800">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- ================== TAMPILAN DESKTOP (Hilang di Mobile) ================== -->
                        <div class="hidden md:block">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Produk
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Harga
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jumlah
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Subtotal
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Hapus</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($cartItems as $item)
                                        <tr>
                                            <!-- Info Produk (Gambar & Nama) -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-16 w-16">
                                                        <img class="h-16 w-16 rounded-md object-cover" 
                                                             src="{{ $item->product->image_url ?? 'https://placehold.co/100x100/EEE/31343C?text=Produk' }}" 
                                                             alt="{{ $item->product->name }}">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900 truncate" style="max-width: 250px;">
                                                            <a href="{{ route('products.show', $item->product) }}" class="hover:text-indigo-600">
                                                                {{ $item->product->name }}
                                                            </a>
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $item->product->category->name ?? 'Kategori' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <!-- Harga Satuan -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                                            </td>
                                            <!-- Jumlah -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $item->quantity }}</div>
                                            </td>
                                            <!-- Subtotal -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-semibold text-gray-900">
                                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                                </div>
                                            </td>
                                            <!-- Tombol Hapus -->
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Total Belanja & Checkout -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="flex justify-between items-baseline">
                                <span class="text-lg font-medium text-gray-600">Total Belanja:</span>
                                <span class="text-3xl font-bold text-gray-900">
                                    Rp {{ number_format($totalPrice, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="mt-6 text-right">
                                <button type="button" class="px-8 py-3 bg-indigo-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Lanjut ke Checkout
                                </button>
                                <p class="mt-3 text-sm text-gray-500">
                                    <a href="{{ route('dashboard') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                                        &larr; Lanjut Belanja
                                    </a>
                                </p>
                            </div>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

