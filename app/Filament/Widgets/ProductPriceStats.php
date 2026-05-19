<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget; // 🚀 Cambiamos a Widget genérico
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductPriceStats extends Widget
{
    use InteractsWithPageFilters; 
    
    // 🚀 Le indicamos qué vista HTML/Blade usar
    protected string $view = 'filament.widgets.product-price-custom-stat';
    
    protected int | string | array $columnSpan = 1;
    protected static ?int $sort = 1; 

    protected function getViewData(): array
    {
        $productId = $this->pageFilters['product_id'] ?? null;
        $startDate = $this->pageFilters['start_date'] ?? null;
        $endDate = $this->pageFilters['end_date'] ?? null;

        if (!$productId) {
            $product = Product::first();
            $productId = $product ? $product->id : null;
        }

        // Valores por defecto
        $latestPrice = 0;
        $formattedPercentage = '0.00%';
        $trend = 'none'; // Valores: 'up', 'down', 'none'
        $trendTitle = 'SIN VARIACIÓN';
        $trendDescription = 'No hay suficientes datos para calcular una tendencia.';

        if ($productId) {
            $prices = Price::where('product_id', $productId)
                ->when($startDate, fn(Builder $q) => $q->whereDate('effective_date', '>=', $startDate))
                ->when($endDate, fn(Builder $q) => $q->whereDate('effective_date', '<=', $endDate))
                ->orderBy('effective_date', 'desc')
                ->take(2)
                ->get();

            if ($prices->isNotEmpty()) {
                $latestPrice = $prices->first()->price;

                if ($prices->count() > 1) {
                    $previousPrice = $prices->last()->price;
                    
                    if ($previousPrice > 0) {
                        $percentageChange = (($latestPrice - $previousPrice) / $previousPrice) * 100;
                        $formattedPercentage = number_format(abs($percentageChange), 2) . '%';

                        if ($percentageChange > 0) {
                            $trend = 'up';
                            $trendTitle = 'AL ALZA';
                            $trendDescription = 'El mercado muestra una tendencia creciente. Recomendamos anticipar compras.';
                        } elseif ($percentageChange < 0) {
                            $trend = 'down';
                            $trendTitle = 'A LA BAJA';
                            $trendDescription = 'El mercado muestra una tendencia decreciente. Buena oportunidad.';
                        }
                    }
                }
            }
        }

        // Retornamos las variables a la vista
        return [
            'latestPrice' => $latestPrice,
            'formattedPercentage' => $formattedPercentage,
            'trend' => $trend,
            'trendTitle' => $trendTitle,
            'trendDescription' => $trendDescription,
        ];
    }
}