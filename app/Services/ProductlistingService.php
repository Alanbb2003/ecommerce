<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductlistingService
{
    public function getCategories()
    {
        return Category::with('children')->whereNull('parent_id')->get();
    }

    public function getProducts(Request $request)
    {
        return Product::query()
            ->with(['category', 'variants'])
            ->where('is_active', true)

            ->when($request->category, function ($query) use ($request) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->where('slug', $request->category)
                        ->orWhereHas('parent', function ($p) use ($request) {
                            $p->where('slug', $request->category);
                        });
                });
            })

            ->when($request->q, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%');
            })

            ->paginate(12)
            ->withQueryString();
    }
}
