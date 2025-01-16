<?php

namespace App\Filament\Resources\InventoryOutResource\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Components\Tables\MoneyColumn;

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
