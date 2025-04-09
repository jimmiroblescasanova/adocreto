<?php

namespace App\Filament\Resources\EstimateResource\Tables;

use App\Filament\Components\Tables\MoneyColumn;
use App\Models\Document;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EstimateTable extends Table
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
                    ->date('d/m/Y')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('folio')
                    ->label('Folio')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('entity.name')
                    ->label('Cliente')
                    ->description(fn (Document $record): string => $record->title)
                    ->sortable()
                    ->searchable()
                    ->grow(),

                MoneyColumn::make('subtotal')
                    ->label('Subtotal'),

                MoneyColumn::make('tax')
                    ->label('IVA'),

                MoneyColumn::make('total')
                    ->label('Total'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Estatus')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
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
