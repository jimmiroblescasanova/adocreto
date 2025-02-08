<?php

namespace App\Filament\Resources\SupplierResource\Tables;

use Filament\Tables;
use App\Enums\IsActive;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SupplierTable extends Table 
{
    public static function table(Table $table): Table
    {
        return $table
        ->modifyQueryUsing(fn (Builder $query) => $query->orderByActiveFirst())
        ->defaultSort(column: 'name', direction: 'asc')
        ->striped()
        ->deferLoading()
        ->deferFilters()
        ->persistSearchInSession()
        ->persistFiltersInSession()
        ->columns([
            Tables\Columns\TextColumn::make('code')
            ->label('#')
            ->searchable()
            ->sortable()
            ->toggleable(),

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
            ->badge()
            ->toggleable(),

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
        ])
        ->bulkActions([
            //
        ]);
    }
}
