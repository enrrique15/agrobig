<?php

namespace App\Filament\Resources\Products\Schemas;

use Faker\Core\File;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre de producto')
                    ->required(),
                Select::make('category_id')
                    ->label('Seleccionar categoía')
                    ->relationship('category', 'name')
                    ->required(),
                Grid::make()
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('stock')
                            ->required()
                            ->numeric()
                            ->default(0),
                        TextInput::make('presentation')
                            ->label('Presentación')
                            ->required(),
                        TextInput::make('abreviation')
                            ->label('Abreviación')
                            ->required(),
                    ]),
                Textarea::make('description')
                    ->label('Descripción'),
                FileUpload::make('image')
                    ->label('Imagen del producto')
                    ->directory('products')
                    ->image(),
                Repeater::make('prices')
                    ->relationship('prices') // <-- Esta línea hace toda la magia de Eloquent
                    ->label('Asignar Precios Iniciales')
                    ->schema([
                        TextInput::make('price')
                            ->label('Precio')
                            ->numeric()
                            ->required()
                            ->prefix('Bs')
                            ->minValue(0),
                    ])
                    ->grid(3) // Los organiza elegantemente en 3 columnas en pantallas grandes
                    ->addActionLabel('Añadir otro precio')
                    ->collapsed(false) // Muestra el campo abierto listo para escribir
                    ->visibleOn('create'), // <-- SÚPER IMPORTANTE

            ]);
    }
}
