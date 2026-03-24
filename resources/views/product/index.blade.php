@if($product->image_path)
    <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
@endif
<p class="mt-2 font-semibold">{{ $product->name }}</p>
<p class="text-gray-700">₱{{ number_format($product->price, 2) }}</p>