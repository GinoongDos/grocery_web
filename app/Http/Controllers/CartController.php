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

    if ($product->quantity < $qty) {
        return redirect()->back()->with('error', 'Not enough stock available.');
    }

    $cart = $request->session()->get('cart', []);
    $cart[$product->id] = ($cart[$product->id] ?? 0) + $qty;

    $request->session()->put('cart', $cart);

    return redirect()->back()->with('status', 'Added to cart!');
}

public function update(Request $request, Product $product)
{
    $data = $request->validate(['quantity' => ['required', 'integer', 'min:0']]);
    $cart = $request->session()->get('cart', []);
    $newQty = $data['quantity'];

    if ($newQty == 0) {
        unset($cart[$product->id]);
    } else {
        if ($product->quantity < $newQty) {
            return redirect()->back()->with('error', 'Not enough stock available.');
        }
        $cart[$product->id] = $newQty;
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
    $cart = $request->session()->get('cart', []);
    if (empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
    }

    $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

    // Check stock availability
    foreach ($cart as $productId => $qty) {
        $product = $products[$productId] ?? null;
        if (!$product || $product->quantity < $qty) {
            return redirect()->route('cart.index')->with('error', 'Insufficient stock for ' . ($product->name ?? 'product') . '.');
        }
    }

    // Deduct quantities
    foreach ($cart as $productId => $qty) {
        $product = $products[$productId];
        $product->decrement('quantity', $qty);
    }

    // Clear the cart
    $request->session()->forget('cart');

    return redirect()->route('products.index')->with('status', 'Thank you for your purchase!');
}
}
