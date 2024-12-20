<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Warehouse;
use Filament\Tables\Table;
use App\Enums\WarehouseTypeEnum;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\WarehouseResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\WarehouseResource\RelationManagers;

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;

    protected static bool $isScopedToTenant = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'almacen';

    protected static ?string $pluralModelLabel = 'almacenes';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('type')
            ->options(WarehouseTypeEnum::class)
            ->required(),

            Forms\Components\TextInput::make('name')
            ->label('Nombre del almacen')
            ->minLength(5)
            ->maxLength(255)
            ->required()
            ->columnSpan(2),

            Forms\Components\Textarea::make('location')
            ->rows(3)
            ->columnSpanFull(),

            Forms\Components\ToggleButtons::make('active')
            ->boolean()
            ->inline()
            ->hiddenOn('create'),
        ])
        ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')
            ->label('Nombre del almacen')
            ->searchable()
            ->sortable()
            ->grow(),

            Tables\Columns\TextColumn::make('type')
            ->label('Tipo'),

            Tables\Columns\TextColumn::make('active')
            ->label('Estado')
            ->badge(),

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
            Tables\Filters\SelectFilter::make('type')
            ->label('Tipo')
            ->options(WarehouseTypeEnum::class),
        ])
        ->deferFilters()
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageWarehouses::route('/'),
        ];
    }
}
