<?php

namespace App\Filament\Resources\Products\Schemas;

use Faker\Core\File;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('category_id')
                    ->label('Seleccionar categoía')
                    ->relationship('category', 'name')
                    ->required(),
                TextInput::make('name')
                    ->label('Nombre de producto')
                    ->required(),
                TextInput::make('price')
                    ->label('Precio')
                    ->required()
                    ->numeric()
                    ->prefix('Bs.'),
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
                Textarea::make('description')
                    ->label('Descripción')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label('Imagen del producto')
                    ->directory('products')
                    ->image()
                    ->columnSpanFull()

            ]);
    }
}
