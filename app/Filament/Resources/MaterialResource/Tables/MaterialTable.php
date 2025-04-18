<?php

namespace App\Filament\Resources\MaterialResource\Tables;

use App\Enums\IsActive;
use Filament\Tables;
use Filament\Tables\Table;

class MaterialTable extends Table
{
    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort(column: 'code', direction: 'asc')
            ->striped()
            ->deferLoading()
            ->deferFilters()
            ->persistSearchInSession()
            ->persistFiltersInSession()
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Código')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
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
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->date()
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Últ. actualización')
                    ->since()
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
                    ->native(false),

                Tables\Filters\SelectFilter::make('active')
                    ->label('Estado')
                    ->options(IsActive::class)
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
