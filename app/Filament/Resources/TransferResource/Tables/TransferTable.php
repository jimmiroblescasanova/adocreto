<?php

namespace App\Filament\Resources\TransferResource\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use App\Enums\TransferStatus;
use Illuminate\Database\Eloquent\Builder;

class TransferTable extends Table
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
            ->date(format: 'd/m/Y')
            ->searchable()
            ->sortable(),

            Tables\Columns\TextColumn::make('folio')
            ->label('Folio')
            ->searchable()
            ->sortable(),

            Tables\Columns\TextColumn::make('title')
            ->label('Título')
            ->searchable()
            ->sortable()
            ->grow(),

            Tables\Columns\TextColumn::make('status')
            ->label('Estado')
            ->badge()
            ->alignCenter(),

            Tables\Columns\TextColumn::make('createdBy.name')
            ->label('Creado por')
            ->sortable()
            ->searchable()
            ->toggleable(isToggledHiddenByDefault: true)
            ->alignCenter(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status')
            ->options(TransferStatus::class)
            ->label('Estado')
            ->native(false),

            Tables\Filters\SelectFilter::make('createdBy.name')
            ->label('Creado por')
            ->searchable()
            ->native(false),
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            //
        ]);
    }
}
