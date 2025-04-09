<?php

namespace App\Filament\Resources\InventoryInResource\Tables;

use App\Filament\Components\Tables\MoneyColumn;
use App\Models\Document;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InventoryInTable extends Table
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
            ->groups([
                ...TableGroups::groups(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Fecha')
                    ->date(format: 'd-m-Y')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('folio')
                    ->label('Folio')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('entity.name')
                    ->label('Proveedor')
                    ->searchable()
                    ->sortable()
                    ->grow()
                    ->description(fn (Document $record): string => $record->title ?? '')
                    ->default('Traspaso'),

                MoneyColumn::make('subtotal')
                    ->label('Subtotal'),

                MoneyColumn::make('tax')
                    ->label('IVA'),

                MoneyColumn::make('total')
                    ->label('Total'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                ...TableFilters::documentFilters(),
            ], layout: FiltersLayout::Modal)
            ->filtersFormColumns(2)
            ->filtersTriggerAction(
                fn (Tables\Actions\Action $action) => $action
                    ->button()
                    ->label('Filtros'),
            )
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }
}
