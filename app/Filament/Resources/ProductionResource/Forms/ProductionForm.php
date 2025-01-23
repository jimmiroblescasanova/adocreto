<?php

namespace App\Filament\Resources\ProductionResource\Forms;

use Filament\Forms;
use App\Models\Product;
use Filament\Forms\Form;
use App\Enums\ProductType;
use App\Models\Production;
use App\Enums\WarehouseType;
use Illuminate\Database\Eloquent\Builder;

class ProductionForm
{
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Section::make('Información general')
            ->schema([
                Forms\Components\TextInput::make('folio')
                ->label('Folio')
                ->default(fn () => Production::getNextFolio())
                ->readOnly(),

                Forms\Components\DatePicker::make('date')
                ->label('Fecha')
                ->default(now()),

                Forms\Components\TextInput::make('title')
                ->label('Titulo')
                ->maxLength(255)
                ->required()
                ->columnSpanFull(),

                Forms\Components\Select::make('origin_warehouse_id')
                ->label('Almacen de insumos')
                ->relationship(name: 'originWarehouse', titleAttribute: 'name', 
                    modifyQueryUsing: fn (Builder $query) => $query->where('type', WarehouseType::SUPPLIES)
                )
                ->searchable()
                ->preload()
                ->optionsLimit(15)
                ->selectablePlaceholder(false)
                ->required(),

                Forms\Components\Select::make('destination_warehouse_id')
                ->label('Almacen de productos terminados')
                ->relationship(name: 'destinationWarehouse', titleAttribute: 'name', 
                    modifyQueryUsing: fn (Builder $query) => $query->where('type', WarehouseType::GENERAL)
                )
                ->searchable()
                ->preload()
                ->optionsLimit(15)
                ->selectablePlaceholder(false)
                ->required(),
            ])
            ->columns(2),

            Forms\Components\Section::make('Productos terminados a producir')
            ->schema([
                Forms\Components\Repeater::make('items')
                ->hiddenLabel()
                ->relationship()
                ->itemLabel(fn (array $state): ?string => isset($state['product_id']) ? self::getProduct($state['product_id'])->name : null)
                ->schema([
                    Forms\Components\Select::make('product_id')
                    ->label('Producto')
                    ->relationship(name: 'product', titleAttribute: 'name', 
                        modifyQueryUsing: fn (Builder $query) => $query->where('type', ProductType::PRODUCT)
                    )
                    ->searchable()
                    ->preload()
                    ->optionsLimit(15)
                    ->selectablePlaceholder(false)
                    ->required()
                    ->live()
                    ->columnSpan(2),

                    Forms\Components\Placeholder::make('unit')
                    ->label('Unidad')
                    ->content(function (Forms\Get $get) {
                        if (!$get('product_id')) {
                            return '';
                        }

                        return self::getProduct($get('product_id'))->unit->name;
                    }),

                    Forms\Components\TextInput::make('quantity')
                    ->label('Cantidad')
                    ->numeric()
                    ->inputMode('decimal')
                    ->step(0.01)
                    ->minValue(0.01)
                    ->required(),
                ])
                ->columns(4)
                ->collapsible(),
            ]),
        ]);
    }

    public static function getProduct(int $productId): Product
    {
        return once(fn () => Product::with('unit')->find($productId));
    }
}
