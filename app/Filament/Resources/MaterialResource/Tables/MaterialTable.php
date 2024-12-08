<?php

namespace App\Filament\Resources\MaterialResource\Tables;

use Filament\Tables;
use Filament\Tables\Table;

class MaterialTable extends Table 
{
    public static function table(Table $table): Table
    {
        return $table
        ->deferLoading()
        ->defaultSort('code', 'asc')
        ->striped()
        ->paginated([25, 50, 100, 'all'])
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
            //
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
        ]);;
    }
}
