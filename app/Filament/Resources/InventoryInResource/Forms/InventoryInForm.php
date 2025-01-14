<?php

namespace App\Filament\Resources\InventoryInResource\Forms;

use Filament\Forms;
use App\Models\Product;
use Filament\Forms\Get;
use App\Models\Document;
use Filament\Forms\Form;
use App\Enums\ProductType;
use App\Enums\DocumentTypeEnum;
use Filament\Forms\Components\Wizard;
use Illuminate\Database\Eloquent\Builder;

class InventoryInForm extends Form 
{
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Wizard::make([
                self::stepGeneral(),

                self::stepItems(),
            ])
            ->columnSpanFull()
        ]);
    }

    public static function stepGeneral(): Wizard\Step
    {
        return Wizard\Step::make('General')
        ->schema([
            Forms\Components\TextInput::make('folio')
            ->label('Folio')
            ->default(fn (): int => Document::getFolio(DocumentTypeEnum::InventoryIn)+1)
            ->readOnly(),

            Forms\Components\DatePicker::make('date')
            ->label('Fecha')
            ->default(now()->toDateString()),

            Forms\Components\Select::make('warehouse_id')
            ->label('Almacén')
            ->relationship(name: 'warehouse', titleAttribute: 'name', 
                modifyQueryUsing: function ($query) {
                return $query->active()->supplies();
            })
            ->searchable()
            ->preload()
            ->optionsLimit(15)
            ->required()
            ->columnSpan(2),

            Forms\Components\Select::make('entity_id')
            ->label('Proveedor')
            ->relationship('entity', 'name')
            ->searchable()
            ->preload()
            ->optionsLimit(15)
            ->required()
            ->selectablePlaceholder(false)
            ->columnSpan(2),

            Forms\Components\TextInput::make('title')
            ->label('Título')
            ->maxLength(255)
            ->columnSpan(2),
        ])
        ->columns(4);
    }

    public static function stepItems(): Wizard\Step
    {
        return Wizard\Step::make('Movimientos')
        ->schema([
            Forms\Components\Repeater::make('items')
            ->relationship()
            ->schema([
                Forms\Components\Select::make('product_id')
                ->label('Material')
                ->relationship(name: 'product', 
                    titleAttribute: 'name', 
                    modifyQueryUsing: fn (Builder $query): Builder => $query->where('type', ProductType::MATERIAL))
                ->searchable(['code', 'name'])
                ->preload()
                ->optionsLimit(10)
                ->required()
                ->columnSpan(2),

                Forms\Components\Placeholder::make('unit')
                ->label('Unidad')
                ->content(function (Get $get): string {
                    return Product::with('unit')->find($get('product_id'))->unit->name ?? '';
                }),

                Forms\Components\TextInput::make('quantity')
                ->label('Cantidad')
                ->numeric()
                ->required(),

                Forms\Components\TextInput::make('price')
                ->label('Costo')
                ->numeric()
                ->required(),
            ])
            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                $data['subtotal'] = $data['quantity'] * $data['price'];
                $data['tax'] = $data['subtotal'] * 0.16;
                $data['total'] = $data['subtotal'] + $data['tax'];
                return $data;
            })
            ->columns(5),
        ]);
    }
}
