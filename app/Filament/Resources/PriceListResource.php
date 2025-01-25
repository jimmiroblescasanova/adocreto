<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\PriceList;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PriceListResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PriceListResource\RelationManagers;

class PriceListResource extends Resource
{
    protected static ?string $model = PriceList::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Configuración';

    protected static ?string $modelLabel = 'lista de precios';

    protected static ?string $pluralModelLabel = 'listas de precios';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->label('Nombre de la lista')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('name', 'asc')
            ->deferLoading()
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label('Nombre de la lista')
                ->searchable()
                ->sortable()
                ->grow(),

                Tables\Columns\TextColumn::make('created_at')
                ->label('Fecha de creación')
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
                Tables\Actions\EditAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['name'] = Str::title($data['name']);
                    return $data;
                }),
                Tables\Actions\DeleteAction::make()
                ->modalDescription('¿Estas seguro? Esta acción, eliminara tambien todos los precios en los productos asociados a esta lista.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePriceLists::route('/'),
        ];
    }
}
