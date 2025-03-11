<?php

namespace App\Filament\Resources\SaleResource\Tables;

use App\Enums\DocumentStatus;
use App\Filament\Components\Tables\MoneyColumn;
use App\Models\Document;
use Filament\Tables;
use Filament\Tables\Table;

class SaleTable extends Table 
{
    public static function table(Table $table): Table
    {
        return $table
        ->defaultSort('id', 'desc')
        ->striped()
        ->deferLoading()
        ->deferFilters()
        ->persistSearchInSession()
        ->persistFiltersInSession()
        ->columns([
            Tables\Columns\TextColumn::make('date')
            ->label('Fecha')
            ->date('d/m/Y')
            ->searchable()
            ->sortable(),

            Tables\Columns\TextColumn::make('folio')
            ->label('Folio')
            ->searchable()
            ->sortable(),

            Tables\Columns\TextColumn::make('entity.name')
            ->label('Cliente')
            ->description(fn (Document $record): string => $record->title)
            ->searchable()
            ->sortable()
            ->grow(),

            Tables\Columns\TextColumn::make('status')
            ->label('Estado')
            ->badge()
            ->toggleable(isToggledHiddenByDefault: true),

            MoneyColumn::make('subtotal')
            ->label('Subtotal'),

            MoneyColumn::make('tax')
            ->label('Impuesto'),

            MoneyColumn::make('total')
            ->label('Total'),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status')
            ->label('Estado')
            ->options(DocumentStatus::class)
            ->native(false),
        ])
        ->filtersTriggerAction(
            fn (Tables\Actions\Action $action) => $action
                ->button()
                ->label('Filtros'),
        )
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
        ]);
    }
}
