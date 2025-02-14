<?php

namespace App\Filament\Resources\InventoryInResource\Forms;

use Filament\Forms;
use App\Models\Product;
use Filament\Forms\Get;
use App\Models\Document;
use Filament\Forms\Form;
use App\Enums\ProductType;
use App\Enums\DocumentType;
use App\Enums\InventoryOperation;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Database\Eloquent\Builder;

class InventoryInForm extends Form 
{
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Wizard::make([
                self::stepGeneral()
                ->columns(3),

                self::stepItems(),
            ])
            ->columnSpanFull(), 
            // TODO: Opcional: agregarlos como campos de texto deshabilitados
            Forms\Components\Fieldset::make('Totales')
            ->schema([
                Forms\Components\Placeholder::make('subtotal')
                ->label('Subtotal')
                ->inlineLabel()
                ->content(fn (Get $get) => "$ " . number_format(self::calculateSubtotal($get('items')), 2, '.', ',')),

                Forms\Components\Placeholder::make('tax')
                ->label('IVA')
                ->inlineLabel()
                ->content(fn (Get $get) => "$ " . number_format(self::calculateTax($get('items')), 2, '.', ',')),

                Forms\Components\Placeholder::make('total')
                ->label('TOTAL')
                ->inlineLabel()
                ->content(fn (Get $get) => "$ " . number_format(self::calculateTotal($get('items')), 2, '.', ',')),
            ])
            ->columns(3),
        ]);
    }

    public static function stepGeneral(): Forms\Components\Wizard\Step
    {
        return Forms\Components\Wizard\Step::make('General')
        ->schema([
            Forms\Components\TextInput::make('folio')
            ->label('Folio')
            ->default(fn (): int => Document::getFolio(DocumentType::InventoryIn)+1)
            ->readOnly(),

            Forms\Components\DatePicker::make('date')
            ->label('Fecha')
            ->default(now()->toDateString())
            ->required(),

            Forms\Components\Select::make('warehouse_id')
            ->label('Almacén')
            ->relationship(name: 'warehouse', titleAttribute: 'name', 
                modifyQueryUsing: function ($query) {
                return $query->active()->supplies();
            })
            ->searchable()
            ->preload()
            ->optionsLimit(15)
            ->required(),

            Forms\Components\TextInput::make('order_number')
            ->label('Número de orden')
            ->maxLength(255)
            ->extraAlpineAttributes([
                'oninput' => 'this.value = this.value.replace(/[^a-zA-Z0-9\-\._\/:#@()\*]/g, "")',
            ]),

            Forms\Components\Select::make('entity_id')
            ->label('Proveedor')
            ->relationship('entity', 'name')
            ->searchable()
            ->preload()
            ->optionsLimit(15)
            ->required()
            ->selectablePlaceholder(false)
            ->columnSpan([
                'md' => 2,
            ]),

            Forms\Components\TextInput::make('title')
            ->label('Título')
            ->maxLength(255)
            ->columnSpanFull(),
        ]);
    }

    public static function stepItems(): Forms\Components\Wizard\Step
    {
        return Forms\Components\Wizard\Step::make('Movimientos')
        ->schema([
            Forms\Components\Repeater::make('items')
            ->relationship()
            ->schema([
                Forms\Components\Select::make('product_id')
                ->label('Material')
                ->relationship(name: 'product', 
                    titleAttribute: 'name', 
                    modifyQueryUsing: fn (Builder $query): Builder => $query->where('type', ProductType::Material))
                ->searchable(['code', 'name'])
                ->preload()
                ->optionsLimit(10)
                ->required()
                ->live()
                ->columnSpan(2),

                Forms\Components\Placeholder::make('unit')
                ->label('Unidad')
                ->content(function (Get $get): string {
                    return Product::with('unit')->find($get('product_id'))->unit->name ?? '';
                }),

                Forms\Components\TextInput::make('quantity')
                ->label('Cantidad')
                ->numeric()
                ->live(onBlur: true)
                ->required(),

                Forms\Components\TextInput::make('price')
                ->label('Costo')
                ->numeric()
                ->live(onBlur: true)
                ->required(),
            ])
            ->mutateRelationshipDataBeforeCreateUsing(function (array $data, Forms\Get $get): array {
                $data['warehouse_id'] = $get('warehouse_id');
                $data['subtotal'] = $data['quantity'] * $data['price'];
                $data['tax'] = $data['subtotal'] * 0.16;
                $data['total'] = $data['subtotal'] + $data['tax'];
                $data['operation'] = InventoryOperation::IN;
                return $data;
            })
            ->columns(5),
        ]);
    }

    private static function calculateSubtotal(array $items): int
    {
        return collect($items)->sum(function($item) {
            return $item['quantity'] * $item['price'];
        });
    }

    private static function calculateTax(array $items): int
    {
        return self::calculateSubtotal($items) * 0.16;
    }

    private static function calculateTotal(array $items): int
    {
        return self::calculateSubtotal($items) + self::calculateTax($items);
    }
}
