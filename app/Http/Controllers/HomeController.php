<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Product::with('category')
            ->where('is_active', true)
            ->latest()
            ->take(10)
            ->get();

        $express = Product::with('category')
            ->where('is_active', true)
            ->where('is_express', true)
            ->take(5)
            ->get();

        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->get();

        $featuredCategories = Category::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order', 'asc')
            ->with(['products' => function ($query) {
                $query->where('is_active', true)->latest()->take(5);
            }])
            ->get();

        return response()->json([
            'featured' => $featured,
            'express' => $express,
            'categories' => $categories,
            'featured_categories' => $featuredCategories,
        ]);
    }
}
