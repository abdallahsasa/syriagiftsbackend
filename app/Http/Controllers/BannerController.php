<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        return response()->json(
            Banner::where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->get()
        );
    }
}
