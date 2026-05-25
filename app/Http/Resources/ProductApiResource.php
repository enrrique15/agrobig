<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductApiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $prices = $this->whenLoaded('prices');
        
        // 1. Establecer el valor por defecto usando la relación directa 'latestPrice'
        $latestPriceValue = $this->latestPrice?->price ?? $this->price ?? 0;
        $variationString = "0.00";
        $trend = "Estable";

        // 2. Si hay un filtro de fechas y se encontraron precios en ese periodo, recalculamos
        if ($prices && $prices->isNotEmpty()) {
            $firstPrice = $prices->first()->price;
            $lastPrice = $prices->last()->price;
            
            // El último precio del periodo pasa a ser el precio actual en pantalla
            $latestPriceValue = $lastPrice;
            
            $variationValue = $lastPrice - $firstPrice;
            
            $sign = $variationValue > 0 ? '+' : '';
            $variationString = $sign . number_format($variationValue, 2, '.', '');

            if ($variationValue > 0) {
                $trend = "Al Alza";
            } elseif ($variationValue < 0) {
                $trend = "A la baja";
            }
        }

        // 3. Estructura final del JSON requerida para la tabla y la gráfica
        return [
            'id' => $this->id,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'abreviation' => $this->abreviation,
            'name' => $this->name,
            'price' => (float) $latestPriceValue,
            'variation' => $variationString,
            'trend' => $trend,
            
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
