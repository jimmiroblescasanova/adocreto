<?php

namespace App\Filament\Resources\TransferResource\Forms;

use Filament\Forms;
use App\Models\Product;
use App\Models\Transfer;
use Filament\Forms\Form;
use App\Models\Warehouse;

class TransferForm extends Form
{
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Wizard::make([
                Forms\Components\Wizard\Step::make('general')
                ->schema([
                    Forms\Components\TextInput::make('folio')
                    ->label('Folio')
                    ->default(fn () => Transfer::getFolio() + 1)
                    ->readOnly(),

                    Forms\Components\DatePicker::make('date')
                    ->label('Fecha')
                    ->default(now())
                    ->required(),

                    Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->maxLength(255)
                    ->required()
                    ->columnSpanFull(),

                    Forms\Components\Select::make('origin_warehouse_id')
                    ->label('Almacén de salida')
                    ->relationship('originWarehouse')
                    ->options(self::generateOptions())
                    ->searchable()
                    ->preload()
                    ->required(),

                    Forms\Components\Select::make('destination_warehouse_id')
                    ->label('Almacén de destino')
                    ->relationship('destinationWarehouse')
                    ->options(self::generateOptions())
                    ->searchable()
                    ->preload()
                    ->required()
                    ->different('origin_warehouse_id'),
                ])
                ->columns(),

                self::getItems(),
            ])
            ->columnSpanFull()
        ]);
    }

    private static function getItems(): Forms\Components\Wizard\Step
    {
        return Forms\Components\Wizard\Step::make('items')
        ->schema([
            Forms\Components\Repeater::make('items')
            ->relationship()
            ->schema([
                Forms\Components\Select::make('product_id')
                ->label('Producto')
                ->relationship(name: 'product', titleAttribute: 'name')
                ->required()
                ->live()
                ->afterStateUpdated(function (Forms\Set $set, $state, Forms\Get $get): void {
                    $set('inventory', self::getInventory($state, $get('../../origin_warehouse_id')) ?? 0);
                })
                ->columnSpan(function (string $operation): string {
                    return match ($operation) {
                        'view' => 3,
                        default => 2,
                    };
                }),

                Forms\Components\TextInput::make('inventory')
                ->label('Inventario')
                ->readOnly()
                ->dehydrated(false),

                Forms\Components\TextInput::make('quantity')
                ->label('Cantidad')
                ->numeric()
                ->minValue(0.1)
                ->required()
                ->lte('inventory'),
            ])
            ->columns(4),
        ]);
    }

    private static function generateOptions(): array
    {
        return once(fn () => Warehouse::getGroupedOptions());
    }

    public static function getInventory(int $productId, int $warehouseId): int|string
    {
        return once(fn () => Product::find($productId)->totalInventory($warehouseId));
    }
}
