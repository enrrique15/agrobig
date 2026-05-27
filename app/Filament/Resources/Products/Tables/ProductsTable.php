<?php

namespace App\Filament\Resources\Products\Tables;

use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->imageHeight(40)
                    ->disk('public')
                    ->label('Imagen')
                    ->circular(),
                TextColumn::make('abreviation')
                    ->label('Abreviación')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('presentation')
                    ->label('Presentación')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('latestPrice.price')
                    ->label('Precio Actual')
                    ->money('BOB')
                    ->sortable()
                    ->badge()
                    ->color('success'),
                TextColumn::make('description')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                ViewAction::make(),
                Action::make('add_price')
                    ->label('Actualizar Precio')
                    ->icon('heroicon-o-currency-dollar')
                    ->color('success')
                    ->modalHeading('Registrar Nuevo Precio')
                    ->modalWidth('md') // Modal pequeño y centrado
                    ->form([
                        TextInput::make('price')
                            ->label('Monto')
                            ->required()
                            ->numeric()
                            ->prefix('Bs')
                            ->minValue(0),
                        DatePicker::make('effective_date')
                            ->label('Fecha de Vigencia')
                            ->default(now())
                            ->required(),
                    ])
                    ->action(function ($record, array $data): void {
                        // Guarda el nuevo precio asociado a este producto
                        $record->prices()->create($data);
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
