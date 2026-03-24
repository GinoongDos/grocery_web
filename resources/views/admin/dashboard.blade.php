<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            {{-- Categories CRUD --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Categories</h3>
                        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md text-sm">
                            + New Category
                        </a>
                    </div>

                    @php
                        $dashboardCategories = \App\Models\Category::latest()->take(10)->get();
                    @endphp

                    <table class="min-w-full text-left text-sm">
                        <thead>
                            <tr>
                                <th class="px-3 py-2">Name</th>
                                <th class="px-3 py-2">Description</th>
                                <th class="px-3 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dashboardCategories as $category)
                                <tr class="border-t border-gray-200 dark:border-gray-700">
                                    <td class="px-3 py-2">{{ $category->name }}</td>
                                    <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
                                        {{ \Illuminate\Support\Str::limit($category->description, 60) }}
                                    </td>
                                    <td class="px-3 py-2 space-x-2">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm"
                                                onclick="return confirm('Delete this category?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-3 py-4 text-center text-gray-500">
                                        No categories yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3 text-right">
                        <a href="{{ route('admin.categories.index') }}" class="text-sm text-indigo-600 hover:underline">
                            View all categories →
                        </a>
                    </div>
                </div>
            </div>

            {{-- Products CRUD --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Products</h3>
                        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md text-sm">
                            + New Product
                        </a>
                    </div>

                    @php
                        $dashboardProducts = \App\Models\Product::with('category')->latest()->take(10)->get();
                    @endphp

                    <table class="min-w-full text-left text-sm">
                        <thead>
                            <tr>
                                <th class="px-3 py-2">Name</th>
                                <th class="px-3 py-2">Category</th>
                                <th class="px-3 py-2">Price</th>
                                <th class="px-3 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dashboardProducts as $product)
                                <tr class="border-t border-gray-200 dark:border-gray-700">
                                    <td class="px-3 py-2">{{ $product->name }}</td>
                                    <td class="px-3 py-2">{{ $product->category?->name }}</td>
                                    <td class="px-3 py-2">₱{{ number_format($product->price, 2) }}</td>
                                    <td class="px-3 py-2 space-x-2">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm"
                                                onclick="return confirm('Delete this product?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-4 text-center text-gray-500">
                                        No products yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3 text-right">
                        <a href="{{ route('admin.products.index') }}" class="text-sm text-indigo-600 hover:underline">
                            View all products →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
