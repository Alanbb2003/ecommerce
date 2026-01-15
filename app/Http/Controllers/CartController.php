<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        // dd($cart);
        return view('cart.cart', compact('cart'));
    }

    public function add(Request $req)
    {
        $data = $req->validate([
            'variant_id' => ['required', 'exists:product_variants,id'],
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $variant = ProductVariant::with('product')->findOrFail($data['variant_id']);

        if ($variant->stock < $data['qty']) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not enough stock'
            ], 422);
        }
        $cart = session()->get('cart', []);

        if (isset($cart[$variant->id])) {
            $cart[$variant->id]['qty'] += $data['qty'];
        } else {
            $cart[$variant->id] = [
                'product_id' => $variant->product_id,
                'name' => $variant->product->name,
                'size' => $variant->size,
                'price' => $variant->price,
                'qty' => $data['qty'],
            ];
        }

        session()->put('cart', $cart);
        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart'
        ]);
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Item not found in cart'
            ], 404);
        }

        unset($cart[$id]);
        session()->put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'message' => 'Product removed from cart'
        ]);
    }
}
