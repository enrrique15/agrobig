<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use App\Models\Product;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Dashboard extends BaseDashboard
{
    public function getColumns(): int | array
    {
        return 3;
    }
    use HasFiltersForm;

   /* public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_id')
                    ->label('Producto')
                    ->options(Product::pluck('name', 'id'))
                    ->default(fn() => Product::first()?->id) 
                    ->searchable(),

                DatePicker::make('start_date')
                    ->label('Desde')
                    ->maxDate(now()),

                DatePicker::make('end_date')
                    ->label('Hasta')
                    ->maxDate(now()),
            ])
            ->columns(2);
    }*/
}
