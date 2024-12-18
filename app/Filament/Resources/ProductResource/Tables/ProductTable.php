<?php

namespace App\Filament\Resources\ProductResource\Tables;

use Filament\Tables;
use Filament\Tables\Table;

class ProductTable extends Table 
{
    public static function table(Table $table): Table
    {
        return $table
        ->deferLoading()
        ->defaultSort('code', 'asc')
        ->persistSearchInSession()
        ->persistFiltersInSession()
        ->columns([
            Tables\Columns\TextColumn::make('code')
            ->label('Código')
            ->searchable()
            ->sortable(),

            Tables\Columns\TextColumn::make('name')
            ->label('Nombre del producto')
            ->searchable()
            ->sortable()
            ->grow(),

            Tables\Columns\TextColumn::make('unit.abbreviation')
            ->label('Unidad')
            ->alignCenter(),

            Tables\Columns\TextColumn::make('category.name')
            ->label('Categoría')
            ->alignCenter(),

            Tables\Columns\TextColumn::make('active')
            ->label('Estado')
            ->badge()
            ->alignCenter(),

            Tables\Columns\TextColumn::make('updated_at')
            ->label('Últ. actualización')
            ->since()
            ->alignEnd()
            ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('created_at')
            ->label('Fecha de creación')
            ->date()
            ->alignEnd()
            ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('category_id')
            ->label('Categoría')
            ->multiple()
            ->relationship(name: 'category', titleAttribute: 'name')
            ->searchable()
            ->preload()
            ->optionsLimit(10),

            Tables\Filters\SelectFilter::make('unit_id')
            ->label('Unidad')
            ->multiple()
            ->relationship(name: 'unit', titleAttribute: 'name')
            ->searchable()
            ->preload()
            ->optionsLimit(10),

            Tables\Filters\TernaryFilter::make('active')
            ->label('Estado')
            ->trueLabel('Activo')
            ->falseLabel('Inactivo'),
        ])
        ->filtersTriggerAction(
            fn (Tables\Actions\Action $action) => $action
                ->button()
                ->label('Filtros'),
        )
        ->deferFilters()
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
        ]);
    }
}
