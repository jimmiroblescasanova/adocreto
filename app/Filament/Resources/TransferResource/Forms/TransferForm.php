<?php

namespace App\Filament\Resources\TransferResource\Forms;

use App\Models\Product;
use App\Models\Transfer;
use App\Models\Warehouse;
use Filament\Forms;
use Filament\Forms\Form;

class TransferForm extends Form
{
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Datos generales')
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

                            Forms\Components\Select::make('warehouse_id')
                                ->label('Almacén de salida')
                                ->relationship('warehouse')
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
                    ->columnSpanFull(),
            ]);
    }

    private static function getItems(): Forms\Components\Wizard\Step
    {
        return Forms\Components\Wizard\Step::make('Movimientos del traspaso')
            ->schema([
                Forms\Components\Repeater::make('items')
                    ->hiddenLabel()
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label('Producto')
                            ->relationship(name: 'product', titleAttribute: 'name')
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->optionsLimit(15)
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Forms\Set $set, $state, Forms\Get $get): void {
                                if ($state) {
                                    $product = self::getProduct($state);
                                    $set('inventory', $product->totalInventory($get('../../warehouse_id')) ?? 0);
                                }
                            })
                            ->columnSpan(function (string $operation): string {
                                return match ($operation) {
                                    'view' => 3,
                                    default => 2,
                                };
                            }),

                        Forms\Components\Placeholder::make('unit')
                            ->label('Unidad')
                            ->content(function (Forms\Get $get) {
                                if ($get('product_id')) {
                                    $product = self::getProduct($get('product_id'));

                                    return $product->unit->name;
                                }
                            }),

                        Forms\Components\TextInput::make('inventory')
                            ->label('Inventario')
                            ->readOnly()
                            ->dehydrated(false)
                            ->visibleOn('create'),

                        Forms\Components\TextInput::make('quantity')
                            ->label('Cantidad')
                            ->numeric()
                            ->minValue(0.1)
                            ->required()
                            ->lte('inventory'),
                    ])
                    ->columns(5),
            ]);
    }

    private static function generateOptions(): array
    {
        return once(fn () => Warehouse::getGroupedOptions());
    }

    public static function getProduct(int $productId): Product
    {
        return once(fn () => Product::find($productId));
    }
}
