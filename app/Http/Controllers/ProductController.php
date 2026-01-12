<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product){
        $product->load(['category', 'variants']);
        // $product = Product::where('slug','=',$slug)->with(['category', 'variants'])->firstOrFail();

        return view('product.productpage', compact('product'));
    }
}
