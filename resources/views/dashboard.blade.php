<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Sukses!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Tampilan Dashboard User (Menampilkan Produk) -->
                    <h3 class="text-2xl font-semibold mb-6">Produk Kami</h3>
                    
                    <!-- 
                        MODIFIKASI:
                        - Grid produk dan penutup </div> dipindahkan ke luar
                    -->
                </div>
            </div>

            <!-- 
                MODIFIKASI:
                - Grid produk sekarang ada di luar div 'bg-white'
                - 'mt-6' ditambahkan untuk memberi jarak dari box di atas
            -->
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($products as $product)
                    <!-- 
                        MODIFIKASI: 
                        - Card ini sekarang menjadi link penuh ke halaman detail
                    -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col relative group transition-shadow duration-150 hover:shadow-lg">
                        
                        <!-- Link Utama (Latar Belakang) -->
                        <a href="{{ route('products.show', $product) }}" class="absolute inset-0 z-10" aria-label="Lihat {{ $product->name }}"></a>

                        <!-- Gambar Produk (Hapus <a>, tambah group-hover) -->
                                <img src="{{ $product->image_url ?? 'https://placehold.co/600x400/EEE/31343C?text=Produk' }}" alt="{{ $product->name }}" class="w-full h-48 object-cover group-hover:opacity-80 transition-opacity duration-150">
                                
                                <div class="p-6 flex-grow flex flex-col">
                                    <!-- Nama Produk (Hapus <a>, tambah group-hover) -->
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-blue-600 transition-colors duration-150">
                                        {{ $product->name }}
                                    </h3>
                                    <p class="text-gray-600 text-sm mt-1 flex-grow">{{ $product->description }}</p>
                                    <p class="text-lg font-bold text-gray-900 mt-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                                    <!-- 
                                        MODIFIKASI:
                                        - Form "Tambah Keranjang" dan "Jumlah" DIHAPUS dari sini.
                                    -->
                                </div>
                            </div>
                        @empty
                            <!-- 
                                MODIFIKASI:
                                {{-- -  @empty block sekarang dibungkus card-nya sendiri --}}
                                - 'col-span-full' agar mengisi satu baris penuh
                            -->
                            <div class="col-span-full bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-center text-gray-500">
                                    <p>Belum ada produk yang tersedia.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
        
                </div>
            </div>
        </x-app-layout>

