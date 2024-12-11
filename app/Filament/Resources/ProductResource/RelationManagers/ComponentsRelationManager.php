<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ComponentsRelationManager extends RelationManager
{
    protected static string $relationship = 'components';

    public function table(Table $table): Table
    {
        return $table
        ->recordTitleAttribute('name')
        ->deferLoading()
        ->defaultSort('code', 'asc')
        ->columns([
            Tables\Columns\TextColumn::make('code')
            ->label('Código'),

            Tables\Columns\TextColumn::make('name')
            ->label('Nombre del material'),

            Tables\Columns\TextColumn::make('quantity')
            ->label('Cantidad')
            ->numeric(decimalPlaces: 2)
            ->alignEnd(),

            Tables\Columns\TextColumn::make('unit.abbreviation')
            ->label('Unidad')
            ->alignEnd(),
        ])
        ->filters([
            //
        ])
        ->headerActions([
            Tables\Actions\AttachAction::make()
            ->label('Añadir')
            ->preloadRecordSelect()
            ->form(fn (Tables\Actions\AttachAction $action): array => [
                $action->getRecordSelect()
                ->searchable(['code', 'name'])
                ->optionsLimit(10),

                Forms\Components\TextInput::make('quantity')
                ->numeric()
                ->required(),
            ]),
        ])
        ->actions([
            Tables\Actions\DetachAction::make()
            ->label('Eliminar'),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DetachBulkAction::make()
                ->label('Eliminar seleccionados'),
            ]),
        ]);
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
