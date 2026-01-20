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

    // public function addOne(Request $request,$id){
    //     $cart = session()->get('cart',[]);

    //     if(!isset($cart[$id])){
    //         return response()->json([
    //             'status'=>'error',
    //             'message'=>'Item not found'
    //         ]);
    //     }

    //     $qty = max(1,(int) $request->qty);

    //     $cart[$id]['qty'] = $qty;
    //     session()->put('cart', $cart);

    //     // return back();
    //     return response()->json([
    //         'status'=>'success',
    //         'message'=>'Added one item',
    //         'qty' =>$qty,
    //     ]);
    // }

    public function update(Request $request, $id)
    {
        if (!in_array($request->action, ['increment', 'decrement'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid action'
            ], 422);
        }
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Item not found'
            ]);
        }

        if ($request->action === 'increment') {
            $cart[$id]['qty'] += 1;
        }
        if ($request->action === 'decrement') {
            if ($cart[$id]['qty'] > 1) {
                $cart[$id]['qty'] -= 1;
            } else {
                unset($cart[$id]);
                session()->put('cart', $cart);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Item removed',
                    'removed' => true,
                ]);
            }
        }
        session()->put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'message' => 'Cart updated',
            'qty' => $cart[$id]['qty'],
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
