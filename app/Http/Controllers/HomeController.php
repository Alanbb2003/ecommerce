<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Services\ProductlistingService;

class HomeController extends Controller
{
    protected ProductlistingService $productlistingService;

    public function __construct(
        ProductlistingService $productlistingService
    ) {
        $this->productlistingService = $productlistingService;
    }

    public function index(Request $request)
    {
        $categories = $this->productlistingService->getCategories();
        $products = $this->productlistingService->getProducts($request);
        return view('home.index', compact('categories', 'products'));
    }
    
}
