<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GreenFarm Market</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap');
        * { font-family: 'Outfit', sans-serif; }
        body { background: linear-gradient(135deg, #0f172a 0%, #1a2a3a 50%, #0f2d1a 100%); }
        .product-card { transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1); }
        .product-card:hover { transform: translateY(-8px) scale(1.02); }
        .shimmer { background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.2) 50%, rgba(255,255,255,0) 100%); }
        .hero-text { color: #ffffff; font-weight: 900; text-shadow: 0 0 20px rgba(132, 204, 22, 0.5); }
    </style>
</head>
<body class="text-gray-100">
    @php $cartCount = array_sum(session('cart', [])); @endphp

    <!-- Custom Modern Header -->
    <header class="fixed top-0 w-full z-50 border-b border-lime-500/20 backdrop-blur-2xl bg-slate-900/40">
        <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
            <a href="{{ route('client.dashboard') }}" class="group flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-lime-400 via-emerald-500 to-teal-600 flex items-center justify-center font-black text-2xl text-white group-hover:shadow-2xl group-hover:shadow-lime-500/50 transition-all duration-300">
                    🌿
                </div>
                <div class="flex flex-col">
                    <span class="hero-text text-2xl font-black">GREENFARM</span>
                    <span class="text-xs text-lime-400/80 tracking-wider">Fresh Organic Produce</span>
                </div>
            </a>

            <div class="flex-1 max-w-md mx-8">
                <form method="GET" action="{{ route('client.dashboard') }}" class="relative">
                    @if (request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search vegetables, fruits..." class="w-full px-5 py-3 pl-12 rounded-full bg-white/10 border-2 border-lime-500 text-white placeholder:text-white/60 focus:border-lime-400 focus:bg-white/20 focus:ring-4 focus:ring-lime-500/40 transition-all outline-none text-sm font-medium shadow-lg">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-lg">🔍</span>
                </form>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('cart.index') }}" class="relative group inline-flex items-center gap-2 px-6 py-3 rounded-full bg-gradient-to-r from-lime-500 to-emerald-600 text-white font-bold text-sm hover:from-lime-600 hover:to-emerald-700 shadow-lg hover:shadow-2xl hover:shadow-lime-500/50 group-hover:scale-110 transition-all duration-300 active:scale-95">
                    <span class="text-xl">🛒</span>
                    Cart
                    @if ($cartCount > 0)
                        <span class="absolute -top-3 -right-2 w-6 h-6 rounded-full bg-red-500 text-white text-xs font-black flex items-center justify-center shadow-lg">{{ min($cartCount, 9) }}</span>
                    @endif
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-6 py-3 rounded-full bg-white/10 hover:bg-white/20 text-white font-bold text-sm border-2 border-white/40 hover:border-lime-500 transition-all duration-300 active:scale-95 shadow-md">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="pt-32 pb-20">
        <!-- Hero Section with Gradient -->
        <section class="relative max-w-7xl mx-auto px-6 mb-20">
            <div class="absolute inset-0 -z-10 overflow-hidden rounded-3xl">
                <div class="absolute top-0 left-1/4 w-96 h-96 bg-lime-500/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
            </div>

            <div class="grid grid-cols-3 gap-8">
                <!-- Sidebar Categories -->
                <div class="col-span-3 lg:col-span-1">
                    <div class="sticky top-40 rounded-2xl bg-gradient-to-b from-slate-800 to-slate-900 border border-lime-500/30 p-6 backdrop-blur-xl shadow-lg">
                        <h3 class="text-xl font-black text-lime-300 mb-6 flex items-center gap-2 drop-shadow-lg">
                            <span class="text-2xl">📂</span>
                            CATEGORIES
                        </h3>
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('client.dashboard', request()->except(['page', 'category'])) }}"
                                   class="block w-full px-5 py-3 rounded-xl font-black text-white text-sm transition-all duration-300 {{ empty($selectedCategoryId) ? 'bg-gradient-to-r from-lime-500 to-emerald-600 text-white shadow-lg shadow-lime-500/60 scale-105' : 'bg-slate-700 text-white/90 hover:bg-slate-600 hover:text-lime-300 hover:shadow-lg' }}">
                                    🛒 All Products
                                </a>
                            </li>
                            @forelse ($categories as $category)
                                <li>
                                    <a href="{{ route('client.dashboard', array_merge(request()->except('page'), ['category' => $category->id])) }}"
                                       class="block w-full px-5 py-3 rounded-xl font-black text-white text-sm transition-all duration-300 {{ (string) $selectedCategoryId === (string) $category->id ? 'bg-gradient-to-r from-lime-500 to-emerald-600 text-white shadow-lg shadow-lime-500/60 scale-105' : 'bg-slate-700 text-white/90 hover:bg-slate-600 hover:text-lime-300 hover:shadow-lg' }}">
                                        📦 {{ $category->name }}
                                    </a>
                                </li>
                            @empty
                                <li class="text-center text-white/70 text-sm py-4 font-bold">No categories</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-span-3 lg:col-span-2">
                    <!-- Status Message -->
                    @if (session('status'))
                        <div class="mb-6 rounded-2xl bg-gradient-to-r from-green-600/40 to-emerald-600/40 border-2 border-green-400 px-6 py-4 text-green-200 font-bold text-sm backdrop-blur-xl flex items-center gap-3 shadow-lg">
                            <span class="text-2xl">✨</span>
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Hero Banner -->
                    <div class="rounded-3xl bg-gradient-to-br from-slate-800 via-slate-800 to-slate-900 border-2 border-lime-500/40 p-10 mb-12 overflow-hidden relative shadow-2xl">
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute top-0 right-0 w-64 h-64 bg-lime-500 rounded-full blur-3xl"></div>
                        </div>
                        <div class="relative z-10">
                            <p class="text-lime-300 text-sm font-black tracking-widest mb-3 flex items-center gap-2">
                                <span>🌱</span> EXCLUSIVE OFFER
                            </p>
                            <h1 class="text-5xl font-black mb-4 hero-text">Fresh Farm to Table</h1>
                            <p class="text-xl text-white font-bold mb-6">Get premium organic produce delivered today. <span class="text-3xl text-red-400 font-black">50% OFF</span></p>
                            <a href="#products" class="inline-flex items-center gap-3 px-8 py-4 rounded-full bg-gradient-to-r from-lime-500 to-emerald-600 text-white font-black text-base hover:from-lime-600 hover:to-emerald-700 hover:shadow-2xl hover:shadow-lime-500/70 hover:scale-110 transition-all duration-300 active:scale-95 shadow-lg">
                                <span>🛍️</span> Shop Now <span>→</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Products Section -->
        <section id="products" class="max-w-7xl mx-auto px-6">
            <div class="mb-12">
                <h2 class="text-5xl font-black mb-3 flex items-center gap-3 text-white drop-shadow-lg">
                    <span class="text-4xl">{{ $selectedCategoryId ? '📦' : '🥕' }}</span>
                    {{ $selectedCategoryId ? 'Category Products' : 'Fresh Collection' }}
                </h2>
                <div class="w-24 h-2 bg-gradient-to-r from-lime-500 to-emerald-600 rounded-full shadow-lg"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse ($products as $product)
                    <article class="product-card group rounded-2xl overflow-hidden bg-gradient-to-b from-slate-800 to-slate-900 border-2 border-lime-500/30 hover:border-lime-500/80 shadow-xl hover:shadow-2xl hover:shadow-lime-500/40 backdrop-blur-xl">
                        <!-- Image Container -->
                        <div class="relative h-32 bg-gradient-to-b from-slate-700 to-slate-800 overflow-hidden flex items-center justify-center">
                            @if ($product->image_path)
                                <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-3 group-hover:scale-125 transition-transform duration-500">
                            @else
                                <div class="text-5xl opacity-50">🥬</div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent group-hover:from-slate-900/40 transition-all duration-300"></div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <p class="text-xs font-black text-lime-300 mb-2 tracking-widest">{{ $product->category?->name ?? '🥒' }}</p>
                            <h3 class="text-lg font-black text-white mb-4 line-clamp-2 group-hover:text-lime-300 transition-colors">{{ $product->name }}</h3>
                            
                            <!-- Price -->
                            <div class="flex items-end gap-3 mb-5">
                                <span class="text-4xl font-black text-lime-300">₱{{ number_format($product->price, 2) }}</span>
                                <span class="text-sm text-white/60 line-through font-bold">₱{{ number_format($product->price * 1.2, 2) }}</span>
                            </div>

                            <!-- Add to Cart -->
                            <form method="POST" action="{{ route('cart.add', $product) }}" class="flex gap-2">
                                @csrf
                                <input type="number" name="quantity" min="1" max="99" value="1" class="w-16 px-3 py-3 rounded-lg bg-white/20 border-2 border-lime-500 text-white font-bold text-center focus:border-lime-400 focus:ring-2 focus:ring-lime-500/50 transition-all outline-none shadow-md">
                                <button type="submit" class="flex-1 px-4 py-3 rounded-lg bg-gradient-to-r from-lime-500 to-emerald-600 font-black text-white hover:from-lime-600 hover:to-emerald-700 hover:shadow-lg hover:shadow-lime-500/70 active:scale-95 transition-all duration-300 flex items-center justify-center gap-2 shadow-lg">
                                    <span>🛒</span> Add
                                </button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-24">
                        <div class="text-8xl mb-4">📪</div>
                        <h3 class="text-3xl font-black text-white mb-2">No Products</h3>
                        <p class="text-white/80 text-lg font-bold">Fresh produce coming soon!</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($products->count())
                <div class="mt-16 flex justify-center">
                    <div class="text-white font-bold text-base">
                        {{ $products->links() }}
                    </div>
                </div>
            @endif
        </section>
    </main>
</body>
</html>
