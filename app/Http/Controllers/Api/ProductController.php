<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductApiResource;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'product_id' => 'nullable|exists:products,id',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $productId = $request->input('product_id');

        $query = Product::query();
        $query->orderBy('id', 'desc');
        if ($productId) {
            $query->where('id', $productId);
        }

        // Eager loading optimizado para rendimiento en tablas paginadas
        $query->with([
            'category', 
            'latestPrice', 
            'prices' => function ($q) use ($startDate, $endDate) {
                if ($startDate) {
                    $q->whereDate('effective_date', '>=', $startDate);
                }
                if ($endDate) {
                    $q->whereDate('effective_date', '<=', $endDate);
                }
                $q->orderBy('effective_date', 'asc'); 
            }
        ]);

        $products = $query->paginate(15);

        return ProductApiResource::collection($products);
    }
}