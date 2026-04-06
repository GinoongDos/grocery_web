<x-client-dashboard-layout>
    @php $cartCount = array_sum(session('cart', [])); @endphp

    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between bg-white/90 backdrop-blur rounded-2xl p-4 shadow-lg dark:bg-slate-950/95">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Welcome back, {{ Auth::user()->name }}</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Browse fresh produce, filter by category, and add items to your cart.</p>
            </div>

            <a href="{{ route('cart.index') }}" class="relative inline-flex items-center gap-3 rounded-full bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/20 hover:bg-emerald-500 transition duration-200">
                <span class="text-base">🛒</span>
                View Cart
                @if ($cartCount > 0)
                    <span class="inline-flex h-6 min-w-[1.5rem] items-center justify-center rounded-full bg-red-500 px-2 text-xs font-black text-white">{{ $cartCount }}</span>
                @endif
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-2xl bg-emerald-50 p-4 text-sm font-semibold text-emerald-900 shadow-sm ring-1 ring-emerald-200 dark:bg-slate-800 dark:text-emerald-200 dark:ring-emerald-700/50">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid gap-8 lg:grid-cols-[280px_1fr]">
                <aside class="space-y-6">
                    <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xl shadow-slate-900/5 backdrop-blur dark:border-slate-700/80 dark:bg-slate-900">
                        <div class="mb-4">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Categories</h3>
                            <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Filter the collection by product type.</p>
                        </div>
                        <nav class="space-y-3">
                            <a href="{{ route('client.dashboard', request()->except(['page', 'category'])) }}" class="block rounded-2xl px-5 py-3 text-sm font-semibold transition {{ empty($selectedCategoryId) ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700' }}">
                                🛒 All Products
                            </a>
                            @forelse ($categories as $category)
                                <a href="{{ route('client.dashboard', array_merge(request()->except('page'), ['category' => $category->id])) }}" class="block rounded-2xl px-5 py-3 text-sm font-semibold transition {{ (string) $selectedCategoryId === (string) $category->id ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700' }}">
                                    📦 {{ $category->name }}
                                </a>
                            @empty
                                <div class="rounded-2xl bg-slate-100 p-4 text-center text-sm font-semibold text-slate-500 dark:bg-slate-800 dark:text-slate-400">No categories available.</div>
                            @endforelse
                        </nav>
                    </div>

                    <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xl shadow-slate-900/5 backdrop-blur dark:border-slate-700/80 dark:bg-slate-900">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Search Products</h3>
                        <form method="GET" action="{{ route('client.dashboard') }}" class="mt-5">
                            @if (request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            <label for="q" class="sr-only">Search</label>
                            <div class="relative">
                                <input id="q" name="q" type="text" value="{{ request('q') }}" placeholder="Search vegetables, fruits..." class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" />
                                <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">🔍</span>
                            </div>
                        </form>
                    </div>
                </aside>

                <section class="space-y-8">
                    <div class="rounded-3xl bg-gradient-to-r from-emerald-600 via-lime-500 to-slate-900 p-8 text-white shadow-2xl shadow-emerald-500/20 overflow-hidden relative">
                        <div class="absolute inset-y-0 right-0 w-60 opacity-20 blur-3xl bg-white/30"></div>
                        <div class="relative z-10 space-y-4">
                            <p class="text-sm uppercase tracking-[0.35em] font-semibold text-emerald-100/90">Fresh Farm to Table</p>
                            <h1 class="text-4xl font-black tracking-tight sm:text-5xl">Organic produce delivered in one click.</h1>
                            <p class="max-w-2xl text-base text-emerald-100/90">Explore the best seasonal fruits, vegetables, and pantry staples. Add your favorites to the cart and enjoy fast, fresh delivery.</p>
                            <a href="#products" class="inline-flex items-center gap-3 rounded-full bg-slate-950/90 px-6 py-3 text-sm font-black uppercase tracking-[0.12em] text-white shadow-lg shadow-slate-950/30 transition hover:bg-slate-900">
                                <span>🛍</span> Browse Products
                            </a>
                        </div>
                    </div>

                    <div>
                        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-white/90 backdrop-blur rounded-2xl p-4 shadow-lg dark:bg-slate-950/95">
                            <div>
                                <h2 class="text-3xl font-white text-slate-900 dark:text-white">{{ $selectedCategoryId ? 'Category Products' : 'Fresh Collection' }}</h2>
                                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ $products->total() }} product{{ $products->total() === 1 ? '' : 's' }} found.</p>
                            </div>
                            @if ($selectedCategoryId)
                                <a href="{{ route('client.dashboard', request()->except(['page', 'category'])) }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                                    Reset Filter
                                </a>
                            @endif
                        </div>

                        <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                            @forelse ($products as $product)
                                <article class="group overflow-hidden rounded-[2rem] border border-slate-200/80 bg-white shadow-xl shadow-slate-900/5 transition hover:-translate-y-1 hover:shadow-2xl dark:border-slate-700/80 dark:bg-slate-950">
                                    <div class="relative h-44 overflow-hidden bg-slate-100 dark:bg-slate-900">
                                        @if ($product->image_path)
                                            <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="h-20 w-23 object-cover transition duration-500 group-hover:scale-105" />
                                        @else
                                            <div class="flex h-24 items-center justify-center text-5xl text-slate-400">🥬</div>
                                        @endif
                                    </div>
                                    <div class="p-6">
                                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-emerald-600">{{ $product->category?->name ?? 'Uncategorized' }}</p>
                                        <h3 class="mt-3 text-xl font-white text-slate-900 dark:text-white">{{ $product->name }}</h3>
                                        <p class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-400">{{ \Illuminate\Support\Str::limit($product->description ?? 'Fresh quality produce available now.', 90) }}</p>

                                        <div class="mt-6 flex items-center justify-between gap-3">
                                            <div>
                                                <p class="text-2xl font-black text-emerald-600">₱{{ number_format($product->price, 2) }}</p>
                                                <p class="text-sm text-slate-400 line-through">₱{{ number_format($product->price * 1.2, 2) }}</p>
                                            </div>
                                        </div>

                                        <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-6 grid gap-3">
                                            @csrf
                                            <div class="grid grid-cols-[80px_1fr] gap-3">
                                                <input type="number" name="quantity" min="1" max="99" value="1" class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-3 py-3 text-sm text-slate-900 outline-none transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" />
                                                <button type="submit" class="rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-black uppercase tracking-[0.12em] text-white transition hover:bg-emerald-500">
                                                    <span class="inline-flex items-center gap-2">🛒 Add</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </article>
                            @empty
                                <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-600 shadow-sm dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300">
                                    <div class="text-6xl">📪</div>
                                    <h3 class="mt-4 text-2xl font-black">No Products</h3>
                                    <p class="mt-2 text-sm">Fresh produce coming soon — check back later.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    @if ($products->hasPages())
                        <div class="flex justify-center">
                            <div class="rounded-3xl border border-slate-200/80 bg-white px-5 py-4 shadow-lg dark:border-slate-700/80 dark:bg-slate-950">
                                {{ $products->links() }}
                            </div>
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </div>
</x-client-dashboard-layout>

