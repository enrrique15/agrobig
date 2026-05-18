<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductApiResource;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('latestPrice')->get();
        return ProductApiResource::collection($products);
    }
}
