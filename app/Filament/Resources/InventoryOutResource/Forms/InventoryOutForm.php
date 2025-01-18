<?php

namespace App\Filament\Resources\InventoryOutResource\Forms;

use Filament\Forms;
use App\Models\Product;
use App\Models\Document;
use Filament\Forms\Form;
use App\Enums\DocumentType;
use App\Enums\InventoryOperation;

class InventoryOutForm extends Form
{
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Wizard::make([
                self::stepGeneral()
                ->columns(4),

                self::stepItems(),
            ])
            ->columnSpanFull(),
        ]);
    }

    public static function stepGeneral(): Forms\Components\Wizard\Step
    {
        return Forms\Components\Wizard\Step::make('Datos generales')
        ->schema([
            Forms\Components\TextInput::make('folio')
            ->label('Folio')
            ->default(fn (): int => Document::getFolio(DocumentType::InventoryOut)+1)
            ->readOnly(),

            Forms\Components\DatePicker::make('date')
            ->label('Fecha')
            ->default(now()->toDateString()),

            Forms\Components\Select::make('warehouse_id')
            ->label('Almacén')
            ->relationship(name: 'warehouse', titleAttribute: 'name', 
                modifyQueryUsing: function ($query) {
                return $query->active();
            })
            ->searchable()
            ->preload()
            ->optionsLimit(15)
            ->required()
            ->columnSpan(2),

            Forms\Components\TextInput::make('title')
            ->label('Título')
            ->maxLength(255)
            ->columnSpanFull()
            ->required(),
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
                ->label('Producto')
                ->relationship(name: 'product', titleAttribute: 'name')
                ->searchable(['code', 'name'])
                ->preload()
                ->optionsLimit(15)
                ->required()
                ->live()
                ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get): void {
                    $product = Product::find($get('product_id'));
                    if ($product) {
                        $set('price', $product->calculateAveragePrice());
                    }
                })
                ->columnSpan(2),

                Forms\Components\Placeholder::make('unit')
                ->label('Unidad')
                ->content(function (Forms\Get $get): string {
                    return Product::with('unit')->find($get('product_id'))->unit->name ?? '';
                }),

                Forms\Components\TextInput::make('quantity')
                ->label('Cantidad')
                ->numeric()
                ->default(1)
                ->live(),

                Forms\Components\TextInput::make('price')
                ->label('Costo')
                ->numeric(),

                Forms\Components\Placeholder::make('available')
                ->label('Disponible')
                ->content(function (Forms\Get $get): mixed {
                    return Product::find($get('product_id'))?->totalInventory($get('../../warehouse_id')) ?? 0;
                }),
            ])
            ->mutateRelationshipDataBeforeCreateUsing(function (array $data, Forms\Get $get): array {
                $data['warehouse_id'] = $get('warehouse_id');
                $data['subtotal'] = $data['quantity'] * $data['price'];
                $data['tax'] = $data['subtotal'] * 0.16;
                $data['total'] = $data['subtotal'] + $data['tax'];
                $data['operation'] = InventoryOperation::OUT; 
                return $data;
            })
            ->columns(6),
        ]);
    }
}

