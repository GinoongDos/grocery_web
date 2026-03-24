<x-app-layout>
    @php
        $cartCount = array_sum(session('cart', []));
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shop Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- SUCCESS MESSAGE --}}
            @if (session('status'))
                <div class="mb-4 flex items-center gap-2 rounded-md bg-green-100 px-4 py-2 text-sm font-medium text-green-800">
                    <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-green-600 text-xs text-white">+</span>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            {{-- HEADER --}}
            <div class="mb-4 flex items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Browse products and add them to your cart.
                </p>

                <a href="{{ route('cart.index') }}"
                   class="relative inline-flex items-center gap-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <circle cx="9" cy="20" r="1.2"></circle>
                        <circle cx="17" cy="20" r="1.2"></circle>
                        <path d="M3 4h2l2.2 10.4a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 2-1.6L21 7H7"></path>
                    </svg>

                    <span>View Cart</span>

                    @if ($cartCount > 0)
                        <span class="absolute -right-2 -top-2 inline-flex h-6 min-w-6 items-center justify-center rounded-full bg-red-600 px-1 text-xs font-bold text-white">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
            </div>

            {{-- PRODUCT GRID --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @forelse ($products as $product)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">

                        {{-- IMAGE (FIXED SIZE) --}}
                        @if ($product->image_path)
                            <div class="flex items-center justify-center h-32 bg-gray-50 dark:bg-gray-700">
                                <img src="{{ asset('storage/'.$product->image_path) }}"
                                     alt="{{ $product->name }}"
                                     class="h-full object-contain">
                            </div>
                        @else
                            <div class="flex items-center justify-center h-32 bg-gray-100 dark:bg-gray-700 text-sm text-gray-500">
                                No image
                            </div>
                        @endif

                        {{-- CONTENT --}}
                        <div class="p-4 text-gray-900 dark:text-gray-100">
                            <p class="font-semibold text-lg">{{ $product->name }}</p>

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $product->category?->name ?? 'Uncategorized' }}
                            </p>

                            <p class="mt-2 text-lg font-bold text-indigo-600">
                                ₱{{ number_format($product->price, 2) }}
                            </p>

                            {{-- ADD TO CART --}}
                            <form method="POST"
                                  action="{{ route('cart.add', $product) }}"
                                  class="mt-4 flex items-center gap-2">

                                @csrf

                                <input
                                    type="number"
                                    name="quantity"
                                    min="1"
                                    value="1"
                                    class="w-20 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                                >

                                <x-primary-button>
                                    Add to Cart
                                </x-primary-button>
                            </form>
                        </div>
                    </div>

                @empty
                    <div class="col-span-full bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                            No products available yet.
                        </div>
                    </div>
                @endforelse

            </div>

            {{-- PAGINATION --}}
            <div class="mt-6">
                {{ $products->links() }}
            </div>

        </div>
    </div>
</x-app-layout>