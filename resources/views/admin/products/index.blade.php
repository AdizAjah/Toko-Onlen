<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- 
            MODIFIKASI: 
            - Padding 'px-4' ditambahkan agar konsisten 
              dengan dashboard di mobile (tidak mepet)
        -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    
                    <!-- Tombol Tambah Produk -->
                    <div class="mb-6 text-right">
                        <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 text-sm font-medium">
                            + Tambah Produk
                        </a>
                    </div>

                    <!-- Notifikasi Sukses -->
                    @if (session('success'))
                        <div class="mb-6 font-medium text-sm text-green-600 bg-green-100 border border-green-300 rounded-md p-4 shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- 
                        MODIFIKASI:
                        - Tabel dibungkus dengan 'overflow-x-auto' agar 
                          hanya tabelnya yang scroll di mobile, tidak merusak layout
                    -->
                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <!-- Kolom Nama & Kategori -->
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama / Kategori
                                    </th>
                                    <!-- Kolom Harga -->
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Harga
                                    </th>
                                    <!-- Kolom Stok -->
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Stok
                                    </th>
                                    <!-- Kolom Tanggal -->
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Terakhir Diubah
                                    </th>
                                    <!-- Kolom Aksi -->
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($products as $product)
                                    <tr>
                                        <!-- Data Nama & Kategori -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                            <!-- Tampilkan nama kategori, cek jika kategori ada (null safety) -->
                                            <div class="text-sm text-gray-500">{{ $product->category->name ?? 'Tanpa Kategori' }}</div>
                                        </td>
                                        <!-- Data Harga -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                        </td>
                                        <!-- Data Stok -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium {{ $product->quantity <= 10 ? 'text-red-600' : 'text-green-600' }}">
                                                {{ $product->quantity }} pcs
                                            </div>
                                        </td>
                                        <!-- Data Tanggal -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900" title="Ditambahkan: {{ $product->created_at->format('d/m/Y H:i') }}">
                                                {{ $product->updated_at->diffForHumans() }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                Ditambah: {{ $product->created_at->format('d M Y') }}
                                            </div>
                                        </td>
                                        <!-- Data Aksi -->
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline ml-4" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <!-- Update colspan menjadi 5 karena ada 5 kolom -->
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                            Belum ada produk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

