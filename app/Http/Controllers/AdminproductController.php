<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Services\ProductlistingService;

class AdminproductController extends Controller
{
   protected ProductlistingService $productlistingService;

   public function __construct(
      ProductlistingService $productlistingService   
   ){
      $this->productlistingService = $productlistingService;
   }

   public function index(Request $request)
   {
      // $categories = Category::with('children')->whereNull('parent_id')->get();
      // $products = Product::query()
      //    ->with(['category', 'variants'])
      //    ->where('is_active', true)

      //    ->when($request->category, function ($query) use ($request) {
      //       $query->whereHas('category', function ($q) use ($request) {
      //          $q->where('slug', $request->category)
      //             ->orWhereHas('parent', function ($p) use ($request) {
      //                $p->where('slug', $request->category);
      //             });
      //       });
      //    })

      //    ->when($request->q, function ($query) use ($request) {
      //       $query->where('name', 'like', '%' . $request->q . '%');
      //    })

      //    ->paginate(12)
      //    ->withQueryString();

      $categories = $this->productlistingService->getCategories();
      $products = $this->productlistingService->getProducts($request);
      return view('admin.products.productsIndex', compact('categories', 'products'));
   }

   public function addNew (Request $request){

   }
}
