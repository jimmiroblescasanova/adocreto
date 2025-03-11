<?php

namespace App\Filament\Resources\SaleResource\Forms;

use Filament\Forms;
use App\Models\Price;
use App\Models\Entity;
use Filament\Forms\Form;
use App\Traits\HasTotalsArea;
use App\Traits\FindsProductsOnce;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;

class SaleForm extends Form 
{
    use FindsProductsOnce;
    use HasTotalsArea;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Group::make([
                Forms\Components\Section::make('Datos de la venta')
                ->icon('heroicon-o-building-storefront')
                ->schema([
                    Forms\Components\Select::make('entity_id')
                    ->label('Seleccionar cliente')
                    ->relationship('entity', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->optionsLimit(15)
                    ->columnSpan(2)
                    ->live(),

                    Forms\Components\Select::make('address')
                    ->label('Direccion del cliente')
                    ->options(function (Forms\Get $get) {
                        $entity = Entity::find($get('entity_id'));
                        if ($entity) {
                            return $entity->addresses->pluck('address_line_1', 'id');
                        }
                    })
                    ->hiddenOn('edit'),

                    Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),

                    Forms\Components\Select::make('warehouse_id')
                    ->label('Seleccionar almacén')
                    ->relationship(name: 'warehouse', titleAttribute: 'name', 
                    modifyQueryUsing: function (Builder $query) {
                        return $query->general();
                    })
                    ->required()
                    ->searchable()
                    ->preload()
                    ->optionsLimit(15),
                ])
                ->columns(3),
            ])
            ->columnSpanFull(),

            Forms\Components\Group::make([
                Forms\Components\Section::make('Productos')
                ->schema([
                    Forms\Components\Repeater::make('items')
                    ->hiddenLabel()
                    ->relationship()
                    ->defaultItems(0)
                    ->schema([
                        Forms\Components\Hidden::make('product_id'),

                        Forms\Components\Placeholder::make('product_name')
                        ->label('Producto')
                        ->columnSpan(3)
                        ->content(function (Forms\Get $get) {
                            return self::getProduct($get('product_id'))?->name ?? '';
                        }),

                        Forms\Components\TextInput::make('quantity')
                        ->label('Cantidad')
                        ->numeric()
                        ->required()
                        ->live(onBlur: true),
                        
                        Forms\Components\TextInput::make('price')
                        ->label('Precio')
                        ->numeric()
                        ->required()
                        ->live(onBlur: true),
                    ])
                    ->columns(5)
                    ->addActionLabel('Agregar producto')
                    ->addAction(function (Action $action) {
                        $action
                        ->modalHeading('Agregar producto')
                        ->modalContent(view('filament.estimate'))
                        ->action(null)
                        ->modalCancelAction(false)
                        ->modalSubmitActionLabel('Continuar');
                    })
                    ->extraItemActions([
                        Forms\Components\Actions\Action::make('selectPrice')
                        ->label('Seleccionar precio')
                        ->icon('heroicon-o-currency-dollar')
                        ->color('success')
                        ->modalHeading('Seleccionar precio')
                        ->fillForm(function (array $arguments, Forms\Components\Repeater $component) {
                            $inputData = $component->getItemState($arguments['item']);
                            return [
                                'price' => $inputData['price'],
                                'product_id' => $inputData['product_id'],
                            ];
                        })
                        ->form([
                            Forms\Components\Select::make('price')
                            ->label('Precio')
                            ->options(function (Forms\Get $get) {
                                return Price::where('product_id', $get('product_id'))->pluck('price', 'price');
                            }),
                        ])
                        ->action(function (
                                array $data, 
                                array $arguments, 
                                Forms\Components\Repeater $component
                            ) {
                            // initialize variables
                            $row = $arguments['item'];
                            $state = $component->getState();
                            // update price
                            $state[$row]['price'] = (int)$data['price'] / 100;
                            // update state
                            $component->state($state);
                        })
                        ->hidden(function (string $operation) {
                            return $operation === 'view';
                        }),
                    ]),
                ]),

                Forms\Components\Fieldset::make('Totales')
                ->schema([
                    Forms\Components\Placeholder::make('subtotal')
                    ->label('Subtotal')
                    ->extraAttributes([
                        'style' => 'font-size: 1.25rem;',
                        'class' => 'text-right font-mono',
                    ])
                    ->content(fn (Forms\Get $get): string => 
                        '$ ' . number_format(HasTotalsArea::calculateSubtotal($get('items')), 2, '.', ',')
                    ),
                    
                    Forms\Components\Placeholder::make('tax')
                    ->label('IVA')
                    ->extraAttributes([
                        'style' => 'font-size: 1.25rem;',
                        'class' => 'text-right font-mono',
                    ])
                    ->content(fn (Forms\Get $get): string => 
                        '$ ' . number_format(HasTotalsArea::calculateTax($get('items')), 2, '.', ',')
                    ),

                    Forms\Components\Placeholder::make('total')
                    ->label('TOTAL')
                    ->extraAttributes([
                        'style' => 'font-size: 1.5rem;',
                        'class' => 'text-right font-bold font-mono',
                    ])
                    ->content(fn (Forms\Get $get): string => 
                        '$ ' . number_format(HasTotalsArea::calculateTotal($get('items')), 2, '.', ',')
                    ),
                ])
                ->columns(3),
            ])
            ->columnSpanFull(),
        ]);
    }
}
