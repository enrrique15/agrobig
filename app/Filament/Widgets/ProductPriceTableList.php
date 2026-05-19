<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class ProductPriceTableList extends TableWidget
{
    protected static ?string $heading = 'Productos';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            // 🚀 TIP: Agregamos ->with('prices') para evitar el problema de consultas N+1 y hacer la tabla más rápida
            ->query(fn(): Builder => Product::query()->with('prices'))
            ->columns([
                ImageColumn::make('image')
                    ->imageHeight(40)
                    ->label('Imagen')
                    ->circular(),
                
                TextColumn::make('abreviation')
                    ->label('Abreviación')
                    ->sortable(),
                
                TextColumn::make('name')
                    ->label('Producto'),
                
                TextColumn::make('latestPrice.price')
                    ->label('Precio Actual')
                    ->money('BOB')
                    ->sortable(),

                // 🚀 NUEVA COLUMNA: VARIACIÓN PORCENTUAL
                TextColumn::make('variacion')
                    ->label('Variación')
                    ->getStateUsing(function (Product $record) {
                        // Obtenemos los últimos 2 precios
                        $prices = $record->prices->sortByDesc('effective_date')->take(2)->values();
                        
                        if ($prices->count() < 2) {
                            return '0.00%';
                        }

                        $latest = $prices[0]->price;
                        $previous = $prices[1]->price;

                        if ($previous == 0) return '0.00%'; // Evitar división por cero

                        $change = (($latest - $previous) / $previous) * 100;
                        $prefix = $change > 0 ? '+' : ''; 
                        
                        return $prefix . number_format($change, 2) . '%';
                    })
                    ->badge()
                    ->color(function (string $state) {
                        if (str_starts_with($state, '+')) return 'success'; // Sube -> Verde
                        if (str_starts_with($state, '-')) return 'danger';  // Baja -> Rojo
                        return 'gray'; // Sin cambios -> Gris
                    }),

                // 🚀 NUEVA COLUMNA: TENDENCIA
                TextColumn::make('tendencia')
                    ->label('Tendencia')
                    ->getStateUsing(function (Product $record) {
                        $prices = $record->prices->sortByDesc('effective_date')->take(2)->values();
                        
                        if ($prices->count() < 2) return 'Estable';

                        $latest = $prices[0]->price;
                        $previous = $prices[1]->price;

                        if ($latest > $previous) return 'Al alza';
                        if ($latest < $previous) return 'A la baja';
                        
                        return 'Estable';
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Al alza' => 'success',
                        'A la baja' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'Al alza' => 'heroicon-m-arrow-trending-up',
                        'A la baja' => 'heroicon-m-arrow-trending-down',
                        default => 'heroicon-m-minus',
                    }),
                
                TextColumn::make('presentation')
                    ->label('Presentación')
                    ->sortable(),
                
                TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                
                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}