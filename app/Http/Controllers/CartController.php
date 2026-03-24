<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
   public function index(Request $request)
{
    $cart = $request->session()->get('cart', []);
    $products = Product::whereIn('id', array_keys($cart))->get();

    $items = [];
    $total = 0;

    foreach ($products as $product) {
        $qty = $cart[$product->id] ?? 0;
        $lineTotal = $product->price * $qty;
        $total += $lineTotal;

        $items[] = compact('product', 'qty', 'lineTotal');
    }

    return view('cart.index', compact('items', 'total'));
}

public function add(Request $request, Product $product)
{
    $request->validate(['quantity' => ['nullable', 'integer', 'min:1']]);
    $qty = $request->input('quantity', 1);

    $cart = $request->session()->get('cart', []);
    $cart[$product->id] = ($cart[$product->id] ?? 0) + $qty;

    $request->session()->put('cart', $cart);

    return redirect()->back()->with('status', 'Added to cart!');
}

public function update(Request $request, Product $product)
{
    $data = $request->validate(['quantity' => ['required', 'integer', 'min:0']]);
    $cart = $request->session()->get('cart', []);

    if ($data['quantity'] == 0) {
        unset($cart[$product->id]);
    } else {
        $cart[$product->id] = $data['quantity'];
    }

    $request->session()->put('cart', $cart);

    return redirect()->route('cart.index')->with('status', 'Cart updated.');
}

public function remove(Request $request, Product $product)
{
    $cart = $request->session()->get('cart', []);
    unset($cart[$product->id]);
    $request->session()->put('cart', $cart);

    return redirect()->route('cart.index')->with('status', 'Item removed.');
}

public function checkout(Request $request)
{
    // Here you would normally create an Order and OrderItems, process payment, etc.
    // For now we just clear the cart.
    $request->session()->forget('cart');

    return redirect()->route('products.index')->with('status', 'Thank you for your purchase!');
}
}
