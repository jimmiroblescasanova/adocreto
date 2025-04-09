<?php

namespace App\Filament\Resources\InventoryOutResource\Tables;

use App\Filament\Components\Tables\MoneyColumn;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InventoryOutTable extends Table
{
    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort(function (Builder $query): Builder {
                return $query
                    ->orderBy('date', 'desc')
                    ->orderBy('folio', 'desc');
            })
            ->deferLoading()
            ->deferFilters()
            ->persistSearchInSession()
            ->persistFiltersInSession()
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Fecha')
                    ->date('d-m-Y')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('folio')
                    ->label('Folio')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->grow(),

                Tables\Columns\TextColumn::make('warehouse.code')
                    ->label('Almacen')
                    ->searchable()
                    ->sortable(),

                MoneyColumn::make('total')
                    ->label('Total'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->alignCenter()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ]);
    }
}
