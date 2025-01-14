<?php 

namespace App\Filament\Resources\InventoryInResource\Tables;

use Filament\Tables;
use App\Models\Document;
use Filament\Tables\Table;
use App\Enums\DocumentStatus;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Sum;
use Illuminate\Database\Query\Builder as QueryBuilder;

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
        ->persistSearchInSession()
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
            ->description(fn (Document $record): string => $record->title ?? ''),

            Tables\Columns\TextColumn::make('warehouse.code')
            ->label('Almacén'),

            self::moneyColumn('subtotal', 'Subtotal'),

            self::moneyColumn('tax', 'IVA'),

            self::moneyColumn('total', 'Total'),

            Tables\Columns\TextColumn::make('status')
            ->label('Estado')
            ->badge()
            ->alignCenter()
            ->toggleable(isToggledHiddenByDefault: false),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            //
        ]);
    }

    public static function moneyColumn(string $column, string $label): Tables\Columns\TextColumn 
    {
        return Tables\Columns\TextColumn::make($column)
        ->label($label)
        ->money(currency: 'MXN')
        ->searchable()
        ->sortable()
        ->alignEnd()
        ->toggleable(isToggledHiddenByDefault: false)
        ->summarize(
            Sum::make()
            ->money(currency: 'MXN', divideBy: 100)
            ->query(fn (QueryBuilder $query): QueryBuilder => $query->where('status', DocumentStatus::PLACED)),
        );
    }
}
