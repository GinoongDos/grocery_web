<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-50">
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
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-emerald-600">Image Products</p>
                    <p class="mt-4 text-4xl font-black text-slate-900">{{ number_format($analytics['with_images']) }}</p>
                    <p class="mt-2 text-sm text-slate-600">Products with uploaded images</p>
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
        </div>
    </div>
</x-app-layout>
