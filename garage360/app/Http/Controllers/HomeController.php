<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;

class HomeController extends Controller
{
    public function index()
    {
        $sliders         = Slider::active()->get();
        $categories      = Category::withCount('products')->where('is_active', true)->orderBy('sort_order')->get();
        $featuredProducts = Product::where('is_featured', true)->where('is_active', true)->latest()->take(8)->get();

        return view('index', compact('sliders', 'categories', 'featuredProducts'));
    }
}
