<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>

            @php
                $criticalStockAlerts = \App\Models\Product::where('quantity', '=', 0)->count() + \App\Models\Product::where('quantity', '<=', 2)->where('quantity', '>', 0)->count();
            @endphp

            @if($criticalStockAlerts > 0)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-semibold">{{ $criticalStockAlerts }} Critical Stock Alert{{ $criticalStockAlerts > 1 ? 's' : '' }}</span>
                </div>
            </div>
            @endif
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @php
                $analytics = [
                    'products' => \App\Models\Product::count(),
                    'categories' => \App\Models\Category::count(),
                    'users' => \App\Models\User::count(),
                    'with_images' => \App\Models\Product::whereNotNull('image_path')->count(),
                    'low_stock' => \App\Models\Product::where('quantity', '<=', 5)->where('quantity', '>', 0)->count(),
                    'out_of_stock' => \App\Models\Product::where('quantity', '=', 0)->count(),
                    'total_stock_value' => \App\Models\Product::sum(\DB::raw('quantity * price')),
                ];
            @endphp

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                <div class="rounded-3xl border border-slate-200/70 bg-white p-6 shadow-xl shadow-slate-900/10 backdrop-blur">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-emerald-600">Products</p>
                    <p class="mt-4 text-4xl font-black text-slate-900">{{ number_format($analytics['products']) }}</p>
                    <p class="mt-2 text-sm text-slate-600">Total products in catalog</p>
                </div>
                <div class="rounded-3xl border border-slate-200/70 bg-white p-6 shadow-xl shadow-slate-900/10 backdrop-blur">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-emerald-600">Categories</p>
                    <p class="mt-4 text-4xl font-black text-slate-900">{{ number_format($analytics['categories']) }}</p>
                    <p class="mt-2 text-sm text-slate-600">Active product categories</p>
                </div>
                <div class="rounded-3xl border border-slate-200/70 bg-white p-6 shadow-xl shadow-slate-900/10 backdrop-blur">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-emerald-600">Users</p>
                    <p class="mt-4 text-4xl font-black text-slate-900">{{ number_format($analytics['users']) }}</p>
                    <p class="mt-2 text-sm text-slate-600">Registered users</p>
                </div>
                <div class="rounded-3xl border border-slate-200/70 bg-white p-6 shadow-xl shadow-slate-900/10 backdrop-blur">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-orange-600">Low Stock</p>
                    <p class="mt-4 text-4xl font-black text-slate-900">{{ number_format($analytics['low_stock']) }}</p>
                    <p class="mt-2 text-sm text-slate-600">Products with ≤5 stock</p>
                </div>
                <div class="rounded-3xl border border-slate-200/70 bg-white p-6 shadow-xl shadow-slate-900/10 backdrop-blur">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-red-600">Out of Stock</p>
                    <p class="mt-4 text-4xl font-black text-slate-900">{{ number_format($analytics['out_of_stock']) }}</p>
                    <p class="mt-2 text-sm text-slate-600">Products with 0 stock</p>
                </div>
                <div class="rounded-3xl border border-slate-200/70 bg-white p-6 shadow-xl shadow-slate-900/10 backdrop-blur">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-blue-600">Stock Value</p>
                    <p class="mt-4 text-4xl font-black text-slate-900">₱{{ number_format($analytics['total_stock_value'], 2) }}</p>
                    <p class="mt-2 text-sm text-slate-600">Total inventory value</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="rounded-3xl border border-slate-200/70 bg-white p-6 shadow-xl shadow-slate-900/10 backdrop-blur">
                    <h3 class="text-lg font-bold text-slate-900">Manage Categories</h3>
                    <p class="mt-2 text-sm text-slate-600">Quick access to category management tools.</p>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-4 py-2 text-sm font-semibold text-black shadow-lg shadow-emerald-500/20 hover:bg-emerald-500">View Categories</a>
                        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-slate-50">New Category</a>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200/70 bg-white p-6 shadow-xl shadow-slate-900/10 backdrop-blur">
                    <h3 class="text-lg font-bold text-slate-900">Manage Products</h3>
                    <p class="mt-2 text-sm text-slate-600">Jump straight to product management.</p>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-4 py-2 text-sm font-semibold text-black shadow-lg shadow-emerald-500/20 hover:bg-emerald-500">View Products</a>
                        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-slate-50">New Product</a>
                    </div>
                </div>
            </div>

            @php
                $lowStockProducts = \App\Models\Product::with('category')->where('quantity', '<=', 5)->where('quantity', '>', 0)->orderBy('quantity')->get();
                $outOfStockProducts = \App\Models\Product::with('category')->where('quantity', '=', 0)->get();
            @endphp

            @if($lowStockProducts->count() > 0 || $outOfStockProducts->count() > 0)
            <div class="rounded-3xl border border-slate-200/70 bg-white p-6 shadow-xl shadow-slate-900/10 backdrop-blur">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Stock Alerts</h3>

                @if($lowStockProducts->count() > 0)
                <div class="mb-6">
                    <h4 class="text-md font-semibold text-orange-600 mb-2">Low Stock Products (≤5)</h4>
                    <div class="space-y-2">
                        @foreach($lowStockProducts as $product)
                        <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                @if($product->image_path)
                                <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="w-10 h-10 rounded object-cover">
                                @endif
                                <div>
                                    <p class="font-medium">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $product->category?->name ?? 'No Category' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-orange-600">{{ $product->quantity }} left</p>
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-sm text-blue-600 hover:underline">Update Stock</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($outOfStockProducts->count() > 0)
                <div>
                    <h4 class="text-md font-semibold text-red-600 mb-2">Out of Stock Products</h4>
                    <div class="space-y-2">
                        @foreach($outOfStockProducts as $product)
                        <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                @if($product->image_path)
                                <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="w-10 h-10 rounded object-cover">
                                @endif
                                <div>
                                    <p class="font-medium">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $product->category?->name ?? 'No Category' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-red-600">Out of Stock</p>
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-sm text-blue-600 hover:underline">Restock</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
