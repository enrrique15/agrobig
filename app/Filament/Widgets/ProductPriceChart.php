<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters; // 🚀 REQUISITO DE LA DOC
use App\Models\Product;
use App\Models\Price;
use Illuminate\Database\Eloquent\Builder;

class ProductPriceChart extends ChartWidget
{
    // 🚀 Cambiamos el trait para escuchar correctamente a la página del Dashboard
    use InteractsWithPageFilters; 

    protected ?string $heading = 'Evolución del Precio';
    protected int | string | array $columnSpan = '2';
    protected ?string $maxHeight = '150px';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // 🚀 Leemos los filtros desde la propiedad nativa '$this->pageFilters'
        $productId = $this->pageFilters['product_id'] ?? null;
        $startDate = $this->pageFilters['start_date'] ?? null;
        $endDate = $this->pageFilters['end_date'] ?? null;

        // Si no hay producto seleccionado, tomamos el primero por defecto
        if (!$productId) {
            $product = Product::first();
            $productId = $product ? $product->id : null;
        }

        if (!$productId) {
            return ['datasets' => [], 'labels' => []];
        }

        // Consultamos aplicando el filtro de producto y el rango de fechas opcional
        $prices = Price::where('product_id', $productId)
            ->when($startDate, fn(Builder $q) => $q->whereDate('effective_date', '>=', $startDate))
            ->when($endDate, fn(Builder $q) => $q->whereDate('effective_date', '<=', $endDate))
            ->orderBy('effective_date', 'asc')
            ->take(30)
            ->get();

        $data = $prices->pluck('price')->toArray();
        
        $labels = $prices->pluck('effective_date')->map(function ($date) {
            return $date->format('d M Y'); 
        })->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Precio (Bs)',
                    'data' => $data,
                    'fill' => 'start',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.15)',
                    'borderColor' => 'rgb(22, 163, 74)',
                    'borderWidth' => 2,
                    'pointBackgroundColor' => 'rgb(22, 163, 74)',
                    'pointRadius' => 3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => false, // Importante para que respete tu max-height
            'elements' => [
                'line' => [
                    'tension' => 0.4,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => false,
                    'grid' => [
                        'color' => 'rgba(0,0,0,0.05)',
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
        ];
    }
}