<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk: ') . $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- 
                MODIFIKASI: 
                Tambahkan notifikasi success/error di sini agar terlihat
                saat menghapus gambar.
            -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Kategori -->
                        <div class="mb-4">
                            <x-input-label for="category_id" :value="__('Kategori')" />
                            <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Nama Produk -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama Produk')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('description', $product->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Harga -->
                        <div class="mb-4">
                            <x-input-label for="price" :value="__('Harga (Rp)')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price', $product->price)" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <!-- Stok (Quantity) -->
                        <div class="mb-4">
                            <x-input-label for="quantity" :value="__('Jumlah Stok')" />
                            <x-text-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" :value="old('quantity', $product->quantity)" required />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>

                        <!-- Upload Gambar -->
                        <div class="mb-4">
                            <x-input-label for="image" :value="__('Ganti Gambar Produk (Opsional)')" />
                            <input id="image" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" type="file" name="image">
                            <p class="mt-1 text-sm text-gray-500" id="file_input_help">PNG, JPG, GIF, WEBP (Maks. 2MB). Kosongkan jika tidak ingin mengganti gambar.</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Perbarui Produk') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <!-- --- MODIFIKASI: TAMBAHKAN BAGIAN INI --- -->
                    <!-- Tampilkan Gambar Saat Ini & Tombol Hapus -->
                    @if ($product->image_url)
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <p class="text-base font-medium text-gray-800">Gambar Saat Ini:</p>
                            <div class="flex items-start gap-4 mt-2">
                                <img src="{{ Storage::url($product->image_url) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded-md border border-gray-200">
                                
                                <!-- Form Hapus Gambar -->
                                <form action="{{ route('admin.products.image.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus gambar ini? Ini tidak bisa dibatalkan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button typeG="submit" class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Hapus Gambar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <p class="text-sm text-gray-500">Produk ini belum memiliki gambar.</p>
                        </div>
                    @endif
                    <!-- ------------------------------------- -->

                </div>
            </div>
        </div>
    </div>
</x-app-layout>