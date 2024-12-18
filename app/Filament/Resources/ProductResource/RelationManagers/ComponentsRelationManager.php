<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use App\Models\Unit;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ComponentsRelationManager extends RelationManager
{
    protected static string $relationship = 'components';

    protected static ?string $title = 'Materiales';

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
        ->headerActions([
            Tables\Actions\AttachAction::make()
            ->label('Añadir')
            ->preloadRecordSelect()
            ->modalHeading('Añadir materia prima')
            ->form(fn (Tables\Actions\AttachAction $action): array => [
                Forms\Components\Group::make([
                    $action->getRecordSelect()
                    ->label('Materia prima')
                    ->searchable(['code', 'name'])
                    ->optionsLimit(10)
                    ->live()
                    ->columnSpanFull(),

                    Forms\Components\TextInput::make('quantity')
                    ->label('Cantidad')
                    ->numeric()
                    ->required(),

                    Forms\Components\Placeholder::make('unit')
                    ->label('Unidad')
                    ->content(function (Forms\Get $get): string {
                        return Unit::query()
                            ->whereHas('materials', function (Builder $query) use ($get){
                                $query->where('id', $get('recordId'));
                            })
                            ->value('name') ?? '';
                    }),
                ])
                ->columns()
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
