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

        $hasDateFilters = $startDate || $endDate;

        $query = Product::query();
        $query->orderBy('id', 'desc');

        if ($productId) {
            $query->where('id', $productId);
        }
        $query->with([
            'category',
            'latestPrice',
            'prices' => function ($q) use ($startDate, $endDate, $hasDateFilters) {
                if ($hasDateFilters) {

                    if ($startDate) {
                        $q->whereDate('effective_date', '>=', $startDate);
                    }
                    if ($endDate) {
                        $q->whereDate('effective_date', '<=', $endDate);
                    }
                    $q->orderBy('effective_date', 'asc');
                } else {

                    $q->orderBy('effective_date', 'desc')->limit(6);
                }
            }
        ]);

        $products = $query->paginate(50);
        if (!$hasDateFilters) {
            $products->getCollection()->transform(function ($product) {
                $product->setRelation('prices', $product->prices->reverse()->values());
                return $product;
            });
        }

        return ProductApiResource::collection($products);
    }

    public function products()
    {
        $products = Product::with('latestPrice')->paginate(50);

        return response()->json([
            'status' => 'success',
            'data' => $products
        ], 200);
    }
}
