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
            ->query(fn(): Builder => Product::query())
            ->columns([
                ImageColumn::make('image')
                    ->imageHeight(40)
                    ->label('Imagen')
                    ->circular(),
                TextColumn::make('abreviation')
                    ->label('Abreviación')

                    ->sortable(),
                TextColumn::make('name'),
                TextColumn::make('latestPrice.price')
                    ->label('Precio Actual')
                    ->money('BOB')
                    ->sortable()
                    ->badge()
                    ->color(function ($state) {

                        if ($state > 500) {
                            return 'danger';
                        }

                        if ($state > 200) {
                            return 'warning';
                        }

                        return 'success';
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
