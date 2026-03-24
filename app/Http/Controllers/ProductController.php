<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'vendor'])->where('is_active', true);

        if ($request->has('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('express')) {
            $query->where('is_express', true);
        }

        return $query->latest()->paginate($request->get('per_page', 20));
    }

    public function show(string $slug)
    {
        return Product::with(['category', 'vendor'])->where('slug', $slug)->firstOrFail();
    }
}
