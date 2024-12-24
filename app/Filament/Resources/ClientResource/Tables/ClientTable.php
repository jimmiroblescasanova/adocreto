<?php

namespace App\Filament\Resources\ClientResource\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use App\Enums\IsActiveEnum;

class ClientTable extends Table 
{
    public static function table(Table $table): Table
    {
        return $table
        ->modifyQueryUsing(function ($query) {
            return $query->clients();
        })
        ->defaultSort('code', 'asc')
        ->deferLoading()
        ->persistSearchInSession()
        ->persistFiltersInSession()
        ->columns([
            Tables\Columns\TextColumn::make('code')
            ->label('Código')
            ->searchable(),

            Tables\Columns\TextColumn::make('name')
            ->label('Nombre del cliente')
            ->searchable()
            ->grow(),

            Tables\Columns\TextColumn::make('rfc')
            ->label('RFC')
            ->searchable(),

            Tables\Columns\TextColumn::make('email')
            ->searchable(),

            Tables\Columns\TextColumn::make('phone')
            ->searchable(),

            Tables\Columns\TextColumn::make('active')
            ->label('Estado')
            ->badge(),

            Tables\Columns\TextColumn::make('created_at')
            ->date()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('updated_at')
            ->since()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('active')
            ->label('Estado')
            ->options(IsActiveEnum::class),
        ])
        ->deferFilters()
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            //
        ]);
    }
}
