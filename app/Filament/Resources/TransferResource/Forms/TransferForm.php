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
                Forms\Components\Wizard\Step::make('General')
                ->schema([
                    Forms\Components\TextInput::make('folio')
                    ->label('Folio')
                    ->default(fn (): int => Transfer::getFolio()+1)
                    ->readOnly(),

                    Forms\Components\DatePicker::make('date')
                    ->label('Fecha')
                    ->default(now()->toDateString())
                    ->required(),

                    Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->columnSpanFull(),

                    Forms\Components\Select::make('origin_warehouse_id')
                    ->label('Almacén de origen')
                    ->relationship(name: 'originWarehouse')
                    ->options(fn () => self::generateOptions())
                    ->searchable()
                    ->preload()
                    ->optionsLimit(15)
                    ->required(),

                    Forms\Components\Select::make('destination_warehouse_id')
                    ->label('Almacén de destino')
                    ->relationship(name: 'destinationWarehouse')
                    ->options(fn () => self::generateOptions())
                    ->searchable()
                    ->preload()
                    ->optionsLimit(15)
                    ->required()
                    ->different('origin_warehouse_id'),
                ])
                ->columns(),

                self::stepItems(),
            ])
            ->columnSpanFull(),
        ]);
    }

    public static function stepItems(): Forms\Components\Wizard\Step
    {
        return Forms\Components\Wizard\Step::make('Productos')
        ->schema([
            Forms\Components\Repeater::make('items')
            ->relationship()
            ->schema([
                Forms\Components\Select::make('product_id')
                ->relationship(name: 'product', titleAttribute: 'name')
                ->searchable()
                ->preload()
                ->optionsLimit(15)
                ->required()
                ->live()
                ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                    if (!is_null($get('product_id')) ) {
                        $set('inventory', self::getInventory($get('product_id'), $get('../../origin_warehouse_id')));
                    }
                })
                ->columnSpan(function (string $operation) {
                    return match ($operation) {
                        'view' => 3,
                        default => 2,
                    };
                }),

                Forms\Components\TextInput::make('inventory')
                ->label('Disponible')
                ->readOnly()
                ->dehydrated(false)
                ->visibleOn('create'),

                Forms\Components\TextInput::make('quantity')
                ->label('Cantidad')
                ->numeric()
                ->minValue(1)
                ->default(1)
                ->lte('inventory')
                ->required(),
            ])
            ->columns(4),
        ]);
    }

    public static function generateOptions(): array
    {
        return once(fn () => Warehouse::getGroupedOptions());
    }

    public static function getInventory(int $productId, int $warehouseId): int|string
    {
        return once(fn () => Product::find($productId)->totalInventory($warehouseId));
    }
}
