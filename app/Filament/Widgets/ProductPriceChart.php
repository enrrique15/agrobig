<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Product;
use App\Models\Price;

class ProductPriceChart extends ChartWidget
{
    protected ?string $heading = 'Evolución del Precio';
    protected int | string | array $columnSpan = 'full';

    protected function getFilters(): ?array
    {
        return Product::pluck('name', 'id')->toArray();
    }

    protected function getData(): array
    {
        // Obtenemos el ID del producto seleccionado en el filtro
        $productId = $this->filter;

        // Si no hay producto seleccionado, tomamos el primero por defecto
        if (!$productId) {
            $product = Product::first();
            $productId = $product ? $product->id : null;
        }

        // Si no hay productos en absoluto, devolvemos un array vacío
        if (!$productId) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        // Buscamos los precios de ese producto ordenados cronológicamente por tu columna custom
        $prices = Price::where('product_id', $productId)
            ->orderBy('effective_date', 'asc')
            ->take(30)
            ->get();

        // Preparamos los datos para Chart.js
        $data = $prices->pluck('price')->toArray();
        
        // Corrección de la conversión: nos aseguramos de transformar el string de la BD a Carbon
        $labels = $prices->pluck('effective_date')->map(function ($date) {
            return $date->format('d M'); 
        })->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Precio (Bs)',
                    'data' => $data,
                    'fill' => 'start',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.15)', // Tono verde traslúcido
                    'borderColor' => 'rgb(22, 163, 74)',         // Línea verde sólida
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
            'elements' => [
                'line' => [
                    'tension' => 0.4, // Suavizado de curvas
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => false, // Ajuste automático al rango de precios real
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