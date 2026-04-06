<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Products') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Manage your product catalog and images.</p>
            </div>

            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 transition">
                + New Product
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('status'))
                        <div class="mb-4 rounded-md bg-green-100 text-green-800 px-4 py-2 text-sm dark:bg-emerald-900 dark:text-emerald-200">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="min-w-full text-left text-sm">
                        <thead>
                            <tr>
                                <th class="px-3 py-2">Image</th>
                                <th class="px-3 py-2">Name</th>
                                <th class="px-3 py-2">Category</th>
                                <th class="px-3 py-2">Price</th>
                                <th class="px-3 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr class="border-t border-gray-200 dark:border-gray-700">
                                    <td class="px-3 py-2">
                                        @if ($product->image_path)
                                            <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="h-16 w-16 rounded object-cover" />
                                        @else
                                            <span class="inline-flex h-16 w-16 items-center justify-center rounded bg-slate-100 text-slate-400 dark:bg-slate-700 dark:text-slate-500">No image</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 font-semibold text-slate-900 dark:text-slate-100">{{ $product->name }}</td>
                                    <td class="px-3 py-2 text-gray-500 dark:text-gray-400">{{ $product->category?->name ?? 'Uncategorized' }}</td>
                                    <td class="px-3 py-2 text-gray-900 dark:text-gray-100">₱{{ number_format($product->price, 2) }}</td>
                                    <td class="px-3 py-2 space-x-2">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm" onclick="return confirm('Delete this product?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-3 py-4 text-center text-gray-500">
                                        No products found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
