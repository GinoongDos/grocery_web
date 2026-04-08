@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Products</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($products as $product)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            @if ($product->image_path)
                                <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded mb-4" />
                            @endif
                            <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
                            <p class="text-gray-600 dark:text-gray-400 mb-2">{{ $product->description }}</p>
                            <p class="text-lg font-bold text-green-600">₱{{ number_format($product->price, 2) }}</p>
                            <p class="text-sm text-gray-500 mb-4">
                                @if ($product->quantity > 0)
                                    In Stock ({{ $product->quantity }})
                                @else
                                    Out of Stock
                                @endif
                            </p>
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="number" name="quantity" value="1" min="1" class="w-16 px-2 py-1 border rounded" {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600 disabled:bg-gray-400 disabled:cursor-not-allowed" {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                                    {{ $product->quantity <= 0 ? 'Out of Stock' : 'Add to Cart' }}
                                </button>
                            </form>
                        </div>
                    @empty
                        <p>No products available.</p>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection