<?php

namespace App\Filament\Resources\SupplierResource\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SupplierTable extends Table 
{
    public static function table(Table $table): Table
    {
        return $table
        ->modifyQueryUsing(function (Builder $query) {
            return $query->activeFirst();
        })
        ->defaultSort(column: 'code', direction: 'asc')
        ->deferLoading()
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

            Tables\Columns\TextColumn::make('rfc')
            ->label('RFC')
            ->searchable()
            ->sortable(),

            Tables\Columns\TextColumn::make('active')
            ->label('Estado')
            ->badge(),

            Tables\Columns\TextColumn::make('created_at')
            ->label('Fecha creación')
            ->date()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('updated_at')
            ->label('Últ. actualización')
            ->since()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }
}
