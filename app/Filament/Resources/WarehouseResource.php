<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Enums\IsActive;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Warehouse;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Enums\WarehouseType;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\WarehouseResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\WarehouseResource\RelationManagers;

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Configuración';

    protected static ?string $modelLabel = 'almacen';

    protected static ?string $pluralModelLabel = 'almacenes';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('type')
            ->label('Tipo de almacen')
            ->options(WarehouseType::class)
            ->required(),

            Forms\Components\TextInput::make('code')
            ->label('Código del almacen')
            ->minLength(5)
            ->maxLength(25)
            ->required()
            ->extraAttributes([
                'onkeydown' => "if (event.key === ' ') { event.preventDefault(); }",
                'oninput' => "this.value = this.value.replace(/\\s+/g, '');",
            ])
            ->live(onBlur: true)
            ->afterStateUpdated(fn (Set $set, ?string $state): string => $set('code', Str::upper($state)))
            ->columnSpan(function (string $operation): string {
                return match ($operation) {
                    'create' => 2,
                    default => 1,
                };
            }),

            Forms\Components\ToggleButtons::make('active')
            ->label('Estado')
            ->options(IsActive::class)
            ->inline()
            ->hiddenOn('create'),

            Forms\Components\TextInput::make('name')
            ->label('Nombre del almacen')
            ->minLength(5)
            ->maxLength(255)
            ->required()
            ->columnSpanFull(),

            Forms\Components\Textarea::make('location')
            ->label('Ubicación')
            ->rows(3)
            ->columnSpanFull(),
        ])
        ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->modifyQueryUsing(fn (Builder $query) => $query->orderByActiveFirst())
        ->defaultSort(function (Builder $query): Builder {
            return $query
                ->orderBy('code', 'asc')
                ->orderBy('name', 'asc');
        })
        ->striped()
        ->deferLoading()
        ->deferFilters()
        ->persistSearchInSession()
        ->persistFiltersInSession()
        ->columns([
            Tables\Columns\TextColumn::make('code')
            ->label('Código')
            ->searchable()
            ->sortable(),

            Tables\Columns\TextColumn::make('name')
            ->label('Nombre del almacen')
            ->searchable()
            ->sortable()
            ->grow(),

            Tables\Columns\TextColumn::make('type')
            ->label('Tipo'),

            Tables\Columns\TextColumn::make('active')
            ->label('Estado')
            ->badge()
            ->toggleable(),

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
            ->options(WarehouseType::class)
            ->native(false),

            Tables\Filters\SelectFilter::make('active')
            ->label('Estado')
            ->options(IsActive::class)
            ->native(false),
        ])
        ->actions([
            Tables\Actions\EditAction::make()
            ->mutateFormDataUsing(function (array $data): array {
                $data['name'] = Str::title($data['name']);

                return $data;
            }),
            
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
