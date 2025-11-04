<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Keranjang Belanja Anda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Cek jika keranjang tidak kosong -->
                    @if ($cartItems->count() > 0)
                        
                        <!-- 
                            MODIFIKASI: Layout Responsif 
                            - 'hidden sm:block' -> Tampil di desktop (table)
                            - 'block sm:hidden' -> Tampil di mobile (cards)
                        -->

                        <!-- Tampilan Desktop (Tabel) -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Produk
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Harga Satuan
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
                                    @foreach ($cartItems as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-16 w-16">
                                                        <!-- 
                                                            MODIFIKASI: 
                                                            Gunakan Storage::url() untuk gambar
                                                        -->
                                                        <img class="h-16 w-16 rounded-md object-cover" 
                                                             src="{{ $item->product->image_url ? Storage::url($item->product->image_url) : 'https://placehold.co/100x100/e2e8f0/cccccc?text=Gambar' }}" 
                                                             alt="{{ $item->product->name }}">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $item->product->name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $item->product->category->name ?? 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $item->quantity }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 font-semibold">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus item ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Tampilan Mobile (Cards) -->
                        <div class="block sm:hidden space-y-4">
                            @foreach ($cartItems as $item)
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                                    <div class="flex gap-4">
                                        <!-- Gambar -->
                                        <div class="flex-shrink-0">
                                            <img class="h-20 w-20 rounded-md object-cover" 
                                                 src="{{ $item->product->image_url ? Storage::url($item->product->image_url) : 'https://placehold.co/100x100/e2e8f0/cccccc?text=Gambar' }}" 
                                                 alt="{{ $item->product->name }}">
                                        </div>
                                        <!-- Detail -->
                                        <div class="flex-grow">
                                            <h3 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h3>
                                            <p class="text-sm text-gray-500">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                            <p class="text-sm text-gray-500">Jumlah: {{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                                        <div>
                                            <span class="text-sm text-gray-500">Subtotal:</span>
                                            <span class="text-sm font-semibold text-gray-900">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                                        </div>
                                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus item ini?')">Hapus</Tton>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        <!-- Total Belanja -->
                        <div class="mt-8 pt-4 border-t border-gray-200">
                            <div class="flex justify-end items-center">
                                <span class="text-lg font-medium text-gray-700">Total Belanja:</span>
                                <span class="text-2xl font-bold text-gray-900 ml-4">
                                    Rp {{ number_format($totalPrice, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex justify-end mt-4">
                                <x-primary-button>
                                    {{ __('Lanjut ke Pembayaran') }}
                                </x-primary-button>
                            </div>
                        </div>

                    @else
                        <!-- Tampilan jika keranjang kosong -->
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900">Keranjang belanja Anda kosong</h3>
                            <p class="mt-1 text-sm text-gray-500">Ayo, mulai belanja dan temukan produk favoritmu!</p>
                            <div class="mt-6">
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    Kembali ke Dashboard
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

