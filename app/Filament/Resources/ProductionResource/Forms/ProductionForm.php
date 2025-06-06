<?php

namespace App\Filament\Resources\ProductionResource\Forms;

use App\Enums\ProductType;
use App\Enums\WarehouseType;
use App\Models\Product;
use App\Models\Production;
use Filament\Forms;
use Filament\Forms\Form;
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
                            ->required(),

                        Forms\Components\Select::make('warehouse_id')
                            ->label('Almacen de meterias primas')
                            ->relationship(name: 'warehouse', titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->where('type', WarehouseType::Supplies)
                            )
                            ->searchable()
                            ->preload()
                            ->optionsLimit(15)
                            ->selectablePlaceholder(false)
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Productos a producir')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->hiddenLabel()
                            ->relationship()
                            ->itemLabel(fn (array $state): ?string => isset($state['product_id']) ? self::getProduct($state['product_id'])->name : null)
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->label('Producto')
                                    ->relationship(name: 'product', titleAttribute: 'name',
                                        modifyQueryUsing: fn (Builder $query) => $query->where('type', ProductType::FinishedProduct)
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
                                        if (! $get('product_id')) {
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
