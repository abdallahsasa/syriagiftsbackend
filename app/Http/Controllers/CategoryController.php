<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('sort_order', 'asc')
            ->get();
    }

    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $products = $category->products()->where('is_active', true)->with('vendor')->latest()->paginate(20);
        
        return response()->json([
            'category' => $category,
            'products' => $products,
        ]);
    }
}
