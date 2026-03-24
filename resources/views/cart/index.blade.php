<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-100 text-green-800 px-4 py-2 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @forelse ($items as $item)
                        <div class="flex flex-col gap-4 border-b border-gray-200 py-4 dark:border-gray-700 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center gap-4">
                                @if ($item['product']->image_path)
                                    <img
                                        src="{{ asset('storage/'.$item['product']->image_path) }}"
                                        alt="{{ $item['product']->name }}"
                                        class="h-16 w-16 rounded object-cover border border-gray-300 dark:border-gray-600"
                                    >
                                @endif

                                <div>
                                    <p class="font-semibold">{{ $item['product']->name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        P{{ number_format($item['product']->price, 2) }} each
                                    </p>
                                    <p class="text-sm font-medium mt-1">
                                        Line total: P{{ number_format($item['lineTotal'], 2) }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <form method="POST" action="{{ route('cart.update', $item['product']) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input
                                        type="number"
                                        name="quantity"
                                        min="0"
                                        value="{{ $item['qty'] }}"
                                        class="w-20 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                                    >
                                    <button type="submit" class="rounded-md border border-gray-300 px-3 py-2 text-sm hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-700">
                                        Update
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('cart.remove', $item['product']) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-md bg-red-600 px-3 py-2 text-sm text-white hover:bg-red-500">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 dark:text-gray-400 py-8">Your cart is empty.</p>
                    @endforelse

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-lg font-semibold">Total: P{{ number_format($total, 2) }}</p>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('dashboard') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-700">
                                Continue Shopping
                            </a>
                            <form method="POST" action="{{ route('cart.checkout') }}">
                                @csrf
                                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-500" @disabled(empty($items))>
                                    Checkout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
