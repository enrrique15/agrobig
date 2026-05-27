<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductApiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $prices = $this->whenLoaded('prices');
        
        // 1. Valores por defecto (si el producto es nuevo y no tiene historial)
        $latestPriceValue = $this->latestPrice?->price ?? $this->price ?? 0;
        
        $variationData = [
            'sign' => '',
            'value' => '0.00%'
        ];

        $trendData = [
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" /></svg>', // Icono de raya (estable)
            'value' => 0.00,
            'text' => 'ESTABLE'
        ];

        if ($prices && $prices->isNotEmpty()) {
            
            $latestPriceValue = $prices->last()->price;
            $n = $prices->count();

            if ($n >= 2) {
                // take(-2) obtiene los últimos dos, values() resetea las llaves a 0 y 1
                $lastTwoPrices = $prices->take(-2)->values(); 
                $pi = $lastTwoPrices[0]->price; 
                $pf = $lastTwoPrices[1]->price; 

                if ($pi > 0) {
                    $v = (($pf - $pi) / $pi) * 100;
                    
                    $variationData['sign'] = $v > 0 ? '+' : ($v < 0 ? '-' : '');
                    $variationData['value'] = number_format(abs($v), 2, '.', '') . '%';
                }
            }

            // --- B) CÁLCULO DE TENDENCIA (Regresión Lineal: Todos los precios) ---
            if ($n >= 2) {
                $sumX = 0; $sumY = 0; $sumXY = 0; $sumX2 = 0;
                $x = 1; // Índice de tiempo secuencial (1, 2, 3...)

                foreach ($prices as $p) {
                    $y = $p->price;
                    $sumX += $x;
                    $sumY += $y;
                    $sumXY += ($x * $y);
                    $sumX2 += ($x * $x);
                    $x++;
                }

                // Fórmula para la pendiente (m)
                $denominator = ($n * $sumX2) - ($sumX * $sumX);
                
                if ($denominator != 0) { // Prevenir división por cero en casos atípicos
                    $m = (($n * $sumXY) - ($sumX * $sumY)) / $denominator;
                    $mFormatted = round($m, 2);

                    $trendData['value'] = $mFormatted;

                    if ($mFormatted > 0) {
                        $trendData['text'] = 'AL ALZA';
                        $trendData['icon'] = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" /></svg>';
                    } elseif ($mFormatted < 0) {
                        $trendData['text'] = 'A LA BAJA';
                        $trendData['icon'] = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.51m-3.182 5.51l-5.511-3.181" /></svg>';
                    }
                }
            }
        }

        // 3. Retorno del JSON estructurado
        return [
            'id' => $this->id,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'abreviation' => $this->abreviation,
            'name' => $this->name,
            'price' => (float) $latestPriceValue,
            'variation' => $variationData,
            'trend' => $trendData,
            
            // Mapeo del historial de precios para la gráfica lineal del frontend
            'prices' => $this->whenLoaded('prices', function () use ($prices) {
                return $prices->map(function ($price) {
                    return [
                        'id' => $price->id,
                        'price' => (float) $price->price,
                        'date' => $price->effective_date->format('d-m-Y'), 
                    ];
                });
            }),
            
            'presentation' => $this->presentation,
            'stock' => $this->stock,
            'category' => $this->category ? $this->category->name : null,
        ];
    }
}