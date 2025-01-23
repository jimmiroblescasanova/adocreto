<?php
namespace App\Filament\Resources\ProductionResource\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use App\Enums\ProductionStatus;
use Illuminate\Database\Eloquent\Builder;

class ProductionTable extends Table 
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
            ->sortable()
            ->searchable(),

            Tables\Columns\TextColumn::make('folio')
            ->label('Folio')
            ->sortable()
            ->searchable(),

            Tables\Columns\TextColumn::make('title')
            ->label('Titulo')
            ->sortable()
            ->searchable()
            ->limit(50)
            ->grow(),

            Tables\Columns\TextColumn::make('status')
            ->label('Estado')
            ->badge(),

            Tables\Columns\TextColumn::make('user.name')
            ->label('Usuario')
            ->sortable()
            ->searchable()
            ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status')
            ->options(ProductionStatus::class)
            ->label('Estado')
            ->native(false),

            Tables\Filters\SelectFilter::make('user.name')
            ->label('Usuario')
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
