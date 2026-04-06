<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @php
                $analytics = [
                    'products' => \App\Models\Product::count(),
                    'categories' => \App\Models\Category::count(),
                    'users' => \App\Models\User::count(),
                    'with_images' => \App\Models\Product::whereNotNull('image_path')->count(),
                ];
            @endphp

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-3xl border border-slate-700 bg-slate-950/90 p-6 shadow-2xl shadow-black/20 backdrop-blur-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Products</p>
                    <p class="mt-4 text-4xl font-black text-white">{{ number_format($analytics['products']) }}</p>
                    <p class="mt-2 text-sm text-slate-400">Total products in catalog</p>
                </div>
                <div class="rounded-3xl border border-slate-700 bg-slate-950/90 p-6 shadow-2xl shadow-black/20 backdrop-blur-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Categories</p>
                    <p class="mt-4 text-4xl font-black text-white">{{ number_format($analytics['categories']) }}</p>
                    <p class="mt-2 text-sm text-slate-400">Active product categories</p>
                </div>
                <div class="rounded-3xl border border-slate-700 bg-slate-950/90 p-6 shadow-2xl shadow-black/20 backdrop-blur-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Users</p>
                    <p class="mt-4 text-4xl font-black text-white">{{ number_format($analytics['users']) }}</p>
                    <p class="mt-2 text-sm text-slate-400">Registered users</p>
                </div>
                <div class="rounded-3xl border border-slate-700 bg-slate-950/90 p-6 shadow-2xl shadow-black/20 backdrop-blur-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Image Products</p>
                    <p class="mt-4 text-4xl font-black text-white">{{ number_format($analytics['with_images']) }}</p>
                    <p class="mt-2 text-sm text-slate-400">Products with uploaded images</p>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                <div class="rounded-3xl border border-slate-700 bg-slate-950/90 p-6 shadow-2xl shadow-black/20 backdrop-blur-sm">
                    <h3 class="text-lg font-semibold text-white">Manage Categories</h3>
                    <p class="mt-2 text-sm text-slate-400">Quick access to category management tools.</p>
                    <div class="mt-4 space-x-2">
                        <a href="{{ route('admin.categories.index') }}" class="inline-flex rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">View Categories</a>
                        <a href="{{ route('admin.categories.create') }}" class="inline-flex rounded-full border border-slate-600 bg-slate-950 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">New Category</a>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-700 bg-slate-950/90 p-6 shadow-2xl shadow-black/20 backdrop-blur-sm">
                    <h3 class="text-lg font-semibold text-white">Manage Products</h3>
                    <p class="mt-2 text-sm text-slate-400">Jump straight to product management.</p>
                    <div class="mt-4 space-x-2">
                        <a href="{{ route('admin.products.index') }}" class="inline-flex rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">View Products</a>
                        <a href="{{ route('admin.products.create') }}" class="inline-flex rounded-full border border-slate-600 bg-slate-950 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">New Product</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
