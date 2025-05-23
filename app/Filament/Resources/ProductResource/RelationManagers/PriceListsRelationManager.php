<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PriceListsRelationManager extends RelationManager
{
    protected static string $relationship = 'price_lists';

    protected static ?string $title = 'Listas de precios';

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn (Builder $query) => $query->whereBelongsTo(Filament::getTenant())
            )
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre de la lista'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Precio')
                    ->money(),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->recordSelectOptionsQuery(
                        fn (Builder $query) => $query->whereBelongsTo(Filament::getTenant())
                    )
                    ->preloadRecordSelect()
                    ->modalHeading('Vincular lista de precios')
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->required(),
                    ]),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
