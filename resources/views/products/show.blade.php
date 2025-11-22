<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Notifikasi Success -->
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
                            <img src="{{ $product->image_url ? Storage::url($product->image_url) : 'https://placehold.co/600x400/e2e8f0/cccccc?text=Gambar+Produk' }}"
                                alt="{{ $product->name }}"
                                class="w-full h-auto object-cover rounded-lg shadow-md border border-gray-200">
                        </div>

                        <!-- Kolom Detail & Form -->
                        <div class="flex flex-col justify-between">
                            <div>
                                <!-- Kategori & Rating -->
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-sm font-semibold text-indigo-600 bg-indigo-100 px-3 py-1 rounded-full">
                                        {{ $product->category->name ?? 'Tidak Berkategori' }}
                                    </span>

                                    <!-- Display Rating Rata-rata -->
                                    <div class="flex items-center" title="Rata-rata Rating: {{ number_format($product->averageRating(), 1) }}">
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <=round($product->averageRating()))
                                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                                </svg>
                                                @else
                                                <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 24 24">
                                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                                </svg>
                                                @endif
                                                @endfor
                                        </div>
                                        <span class="ml-2 text-gray-600 text-sm">
                                            ({{ $product->ratings->count() }} ulasan)
                                        </span>
                                    </div>
                                </div>

                                <!-- Nama Produk -->
                                <h1 class="text-3xl font-bold text-gray-800 mt-3 mb-2">
                                    {{ $product->name }}
                                </h1>

                                <!-- Brand (jika ada) -->
                                @if($product->brand)
                                <p class="text-lg text-gray-600 mb-2">
                                    Merek: <span class="font-semibold">{{ $product->brand }}</span>
                                </p>
                                @endif

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
                                <div class="mb-4">
                                    <span class="text-sm font-medium text-gray-700">
                                        Stok Tersisa:
                                        <span class="font-bold {{ $product->quantity > 10 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $product->quantity }}
                                        </span>
                                    </span>
                                </div>

                                @if ($product->quantity > 0)
                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <div class="flex items-center gap-4 mb-4">
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

                                        <x-primary-button class="w-full justify-center text-base py-3">
                                            {{ __('+ Tambah ke Keranjang') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                                @else
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

            <!-- Bagian Ulasan & Rating -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Ulasan & Penilaian</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Form Input Rating -->
                        <div>
                            @auth
                            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                                <h4 class="text-lg font-semibold mb-4">Berikan Penilaian Anda</h4>
                                <form action="{{ route('rating.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <div class="mb-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Rating</label>
                                        <div class="flex space-x-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer">
                                                <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                                                <svg class="w-8 h-8 text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 fill-current transition-colors" viewBox="0 0 24 24">
                                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                                </svg>
                                                </label>
                                                @endfor
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="review" class="block text-gray-700 text-sm font-bold mb-2">Ulasan (Opsional)</label>
                                        <textarea name="review" id="review" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Tulis pengalaman Anda tentang produk ini..."></textarea>
                                    </div>

                                    <x-primary-button>
                                        {{ __('Kirim Penilaian') }}
                                    </x-primary-button>
                                </form>
                            </div>
                            @else
                            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 text-yellow-800">
                                Silakan <a href="{{ route('login') }}" class="font-bold underline">login</a> untuk memberikan penilaian.
                            </div>
                            @endauth
                        </div>

                        <!-- Daftar Ulasan -->
                        <div>
                            <h4 class="text-lg font-semibold mb-4">Apa kata mereka?</h4>
                            @if($product->ratings->count() > 0)
                            <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                                @foreach($product->ratings as $rating)
                                <div class="border-b border-gray-100 pb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="font-bold text-gray-800">{{ $rating->user->name }}</span>
                                        <span class="text-xs text-gray-500">{{ $rating->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex text-yellow-400 mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <=$rating->rating)
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                            </svg>
                                            @else
                                            <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 24 24">
                                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                            </svg>
                                            @endif
                                            @endfor
                                    </div>
                                    @if($rating->review)
                                    <p class="text-gray-600 text-sm">{{ $rating->review }}</p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @else
                            <p class="text-gray-500 italic">Belum ada ulasan untuk produk ini.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Produk Serupa -->
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Produk Serupa</h3>

                @if($relatedProducts->count() > 0)
                <div class="flex overflow-x-auto space-x-6 pb-4 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                    @foreach($relatedProducts as $related)
                    <div class="flex-none w-64 bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                        <img src="{{ $related->image_url ? Storage::url($related->image_url) : 'https://placehold.co/600x400/e2e8f0/cccccc?text=Gambar+Produk' }}"
                            alt="{{ $related->name }}"
                            class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-800 truncate" title="{{ $related->name }}">
                                {{ $related->name }}
                            </h4>
                            <div class="flex items-center mb-1">
                                <div class="flex text-yellow-400 text-xs">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <=round($related->averageRating()))
                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                        </svg>
                                        @else
                                        <svg class="w-3 h-3 text-gray-300 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                        </svg>
                                        @endif
                                        @endfor
                                </div>
                            </div>
                            <p class="text-indigo-600 font-bold mt-1">
                                Rp {{ number_format($related->price, 0, ',', '.') }}
                            </p>
                            <a href="{{ route('products.show', $related) }}" class="block mt-3 text-center bg-gray-900 text-white text-sm py-2 rounded hover:bg-gray-800 transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-gray-500 text-center py-8 bg-gray-50 rounded-lg border border-gray-100">
                    <p>Tidak ada produk yang serupa.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>