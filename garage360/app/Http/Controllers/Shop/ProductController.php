<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('brand', 'like', "%{$request->search}%")
                  ->orWhere('oem_number', 'like', "%{$request->search}%");
            });
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->brand) {
            $query->where('brand', $request->brand);
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        $query->when($request->sort, function ($q, $sort) {
            match($sort) {
                'price_asc'  => $q->orderBy('price'),
                'price_desc' => $q->orderByDesc('price'),
                default      => $q->latest(),
            };
        }, fn($q) => $q->latest());

        $products   = $query->paginate(12);
        $categories = Category::withCount('products')->where('is_active', true)->get();
        $brands     = Product::where('is_active', true)->whereNotNull('brand')->distinct()->pluck('brand');

        return view('products.index', compact('products', 'categories', 'brands'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);
        $product->load('category');

        return view('products.show', compact('product'));
    }
}
