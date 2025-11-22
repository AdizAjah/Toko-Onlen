<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- 
            MODIFIKASI: 
            - Menambahkan 'px-4' untuk padding horizontal di layar mobile 
        -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="lg:grid lg:grid-cols-4 lg:gap-8">

                <!-- SIDEBAR (Filter) -->
                <div class="lg:col-span-1 mb-6 lg:mb-0" x-data="{ showFilters: false }">
                    <!-- 
                        MODIFIKASI: 
                        Filter dipindahkan ke sidebar (sticky di desktop)
                        Mobile: Collapsible (Accordion)
                    -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-24">
                        <div class="p-4 sm:p-6 text-gray-900">

                            <!-- Header Filter (Mobile Toggle) -->
                            <div class="flex items-center justify-between lg:block cursor-pointer lg:cursor-default" @click="showFilters = !showFilters">
                                <h3 class="font-semibold text-lg flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    Filter & Kategori
                                </h3>
                                <!-- Icon Chevron (Mobile Only) -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 lg:hidden transition-transform duration-200" :class="{'rotate-180': showFilters}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>

                            <!-- Form Filter (Hidden on Mobile by default, visible on Desktop) -->
                            <div :class="{'hidden': !showFilters, 'block': showFilters}" class="hidden lg:block mt-4 lg:mt-4">
                                <form action="{{ route('dashboard') }}" method="GET" class="space-y-6">
                                    <!-- Hidden Inputs untuk menjaga state search -->
                                    @if($search) <input type="hidden" name="search" value="{{ $search }}"> @endif

                                    <!-- Kategori (Vertical List) -->
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700 mb-3">Kategori</h4>
                                        <div class="space-y-2 max-h-60 overflow-y-auto custom-scrollbar pr-1">
                                            <!-- Link Semua Kategori -->
                                            @php
                                            $queryAll = request()->query();
                                            unset($queryAll['category_id']);
                                            @endphp
                                            <a href="{{ route('dashboard', $queryAll) }}"
                                                class="block text-sm px-2 py-1.5 rounded-md transition-colors {{ !$selectedCategory ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">
                                                Semua Kategori
                                            </a>

                                            @foreach ($categories as $category)
                                            <a href="{{ route('dashboard', array_merge(request()->query(), ['category_id' => $category->id])) }}"
                                                class="block text-sm px-2 py-1.5 rounded-md transition-colors {{ $selectedCategory == $category->id ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">
                                                {{ $category->name }}
                                            </a>
                                            @endforeach
                                        </div>
                                    </div>

                                    <hr class="border-gray-200">

                                    <!-- Filter Harga -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Rentang Harga</label>
                                        <div class="space-y-2">
                                            <div class="relative">
                                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 text-xs">Rp</span>
                                                <input type="number" name="min_price" placeholder="Min" value="{{ $minPrice ?? '' }}"
                                                    class="w-full pl-8 text-sm rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div class="relative">
                                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 text-xs">Rp</span>
                                                <input type="number" name="max_price" placeholder="Max" value="{{ $maxPrice ?? '' }}"
                                                    class="w-full pl-8 text-sm rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Filter Brand -->
                                    @if($brands->count() > 0)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Merek</label>
                                        <select name="brand" class="w-full text-sm rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Semua Merek</option>
                                            @foreach($brands as $brand)
                                            <option value="{{ $brand }}" {{ ($selectedBrand ?? '') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif

                                    <!-- Buttons -->
                                    <div class="pt-2 flex flex-col gap-2">
                                        <x-primary-button class="w-full justify-center">
                                            Terapkan
                                        </x-primary-button>
                                        <a href="{{ route('dashboard') }}" class="text-center text-sm text-gray-500 hover:text-gray-800 transition-colors">
                                            Reset Filter
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MAIN CONTENT (Products) -->
                <div class="lg:col-span-3">

                    <!-- Notifikasi Sukses -->
                    @if (session('success'))
                    <div class="mb-6 font-medium text-sm text-green-600 bg-green-100 border border-green-300 rounded-md p-4 shadow-sm flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        {{ session('success') }}
                    </div>
                    @endif

                    <!-- Header Section -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-800">
                            @if ($selectedCategory)
                            {{ $categories->find($selectedCategory)->name }}
                            @elseif ($search)
                            Hasil: "{{ $search }}"
                            @else
                            Semua Produk
                            @endif
                        </h3>
                        <span class="text-sm text-gray-500">
                            Menampilkan {{ $products->count() }} produk
                        </span>
                    </div>

                    <!-- Grid Produk -->
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                        @forelse ($products as $product)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col relative group transition-all duration-300 hover:shadow-xl border border-gray-100">

                            <!-- Badge Stok -->
                            @if($product->quantity > 0)
                            <span class="absolute top-2 right-2 z-20 text-white text-[10px] px-2 py-1 rounded-full uppercase font-bold tracking-wide {{ $product->quantity > 10 ? 'bg-green-500' : 'bg-yellow-500' }}">
                                {{ $product->quantity <= 10 ? 'Sisa ' . $product->quantity : 'Ready' }}
                            </span>
                            @else
                            <span class="absolute top-2 right-2 z-20 bg-red-500 text-white text-[10px] px-2 py-1 rounded-full uppercase font-bold tracking-wide">
                                Habis
                            </span>
                            @endif

                            <!-- Link Wrapper -->
                            <a href="{{ route('products.show', $product) }}" class="absolute inset-0 z-10"></a>

                            <!-- Gambar -->
                            <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-200 relative">
                                <img src="{{ $product->image_url ? Storage::url($product->image_url) : 'https://placehold.co/600x400/e2e8f0/cccccc?text=No+Image' }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-48 object-cover object-center transition-transform duration-500 group-hover:scale-110
                                                @if($product->quantity <= 0) opacity-50 grayscale @endif">
                            </div>

                            <!-- Info Produk -->
                            <div class="p-4 flex flex-col flex-grow">
                                <div class="mb-1">
                                    <span class="text-xs font-semibold text-indigo-600 uppercase tracking-wider">
                                        {{ $product->category->name ?? 'Umum' }}
                                    </span>
                                </div>
                                <h4 class="text-sm sm:text-base font-bold text-gray-900 mb-1 line-clamp-2 leading-tight group-hover:text-indigo-700 transition-colors">
                                    {{ $product->name }}
                                </h4>
                                @if($product->brand)
                                <p class="text-xs text-gray-500 mb-2">{{ $product->brand }}</p>
                                @endif

                                <div class="mt-auto pt-2 flex items-center justify-between">
                                    <p class="text-lg font-extrabold text-gray-900">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                    <!-- Icon Cart Kecil (Visual Only) -->
                                    <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full bg-white rounded-lg shadow-sm p-12 text-center border border-dashed border-gray-300">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada produk ditemukan</h3>
                            <p class="mt-1 text-sm text-gray-500">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
                            <div class="mt-6">
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Reset Semua Filter
                                </a>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>