<?php

namespace App\Filament\Resources\EstimateResource\Forms;

use App\Enums\EntityType;
use App\Enums\InventoryOperation;
use App\Filament\Resources\ClientResource\Forms\ClientForm;
use App\Models\Document;
use App\Models\Entity;
use App\Models\Price;
use App\Traits\FindsProductsOnce;
use App\Traits\HasTotalsArea;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;

class EstimateForm extends Form
{
    use FindsProductsOnce;
    use HasTotalsArea;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make([
                    Forms\Components\Section::make('Datos del cliente')
                        ->schema([
                            Forms\Components\Select::make('entity_id')
                                ->label('Selecciona un cliente')
                                ->relationship('entity', 'name', modifyQueryUsing: function ($query) {
                                    return $query->where('type', EntityType::Client);
                                })
                                ->searchable()
                                ->preload()
                                ->optionsLimit(15)
                                ->native(false)
                                ->required()
                                ->createOptionForm(fn (Form $form) => ClientForm::form($form))
                                ->createOptionUsing(fn (array $data) => self::createNewClient($data))
                                ->live()
                                ->disabledOn('edit'),

                            Forms\Components\TextInput::make('title')
                                ->label('Titulo'),

                            Forms\Components\Select::make('address')
                                ->label('Seleccionar dirección')
                                ->options(function (Forms\Get $get) {
                                    $entity = Entity::find($get('entity_id'));
                                    if ($entity) {
                                        return $entity->addresses->pluck('address_line_1', 'id');
                                    }
                                })
                                ->hiddenOn('edit'),

                            Forms\Components\Placeholder::make('address')
                                ->label('Dirección seleccionada')
                                ->content(function (Document $record) {
                                    return $record->address?->address_line_1 ?? '';
                                })
                                ->hiddenOn('create'),
                        ])
                        ->columns(2),
                ])
                    ->columnSpanFull(),

                Forms\Components\Group::make([
                    Forms\Components\Section::make('Productos')
                        ->icon('heroicon-o-shopping-cart')
                        ->schema([
                            Forms\Components\Repeater::make('items')
                                ->hiddenLabel()
                                ->relationship()
                                ->defaultItems(0)
                                ->schema([
                                    Forms\Components\Hidden::make('product_id'),

                                    Forms\Components\Placeholder::make('product_name')
                                        ->label('Producto')
                                        ->columnSpan(2)
                                        ->content(function (Forms\Get $get) {
                                            return self::getProduct($get('product_id'))?->name ?? '';
                                        }),

                                    Forms\Components\TextInput::make('quantity')
                                        ->label('Cantidad')
                                        ->numeric()
                                        ->required()
                                        ->live(),

                                    Forms\Components\TextInput::make('price')
                                        ->label('Precio')
                                        ->numeric()
                                        ->required()
                                        ->live(),
                                ])
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
                                            $state[$row]['price'] = (int) $data['price'] / 100;
                                            // update state
                                            $component->state($state);
                                        })
                                        ->hidden(function (string $operation) {
                                            return $operation === 'view';
                                        }),
                                ])
                                ->mutateRelationshipDataBeforeCreateUsing(fn (array $data) => self::mutateRepeaterData($data))
                                ->columns(4),
                        ])
                        ->columnSpan(2),

                    Forms\Components\Section::make('Totales')
                        ->schema([
                            Forms\Components\Placeholder::make('subtotal')
                                ->label('Subtotal')
                                ->extraAttributes([
                                    'style' => 'font-size: 1.25rem;',
                                    'class' => 'text-right font-mono',
                                ])
                                ->content(fn (Forms\Get $get): string => '$ '.number_format(HasTotalsArea::calculateSubtotal($get('items')), 2, '.', ',')
                                ),

                            Forms\Components\Placeholder::make('tax')
                                ->label('IVA')
                                ->extraAttributes([
                                    'style' => 'font-size: 1.25rem;',
                                    'class' => 'text-right font-mono',
                                ])
                                ->content(fn (Forms\Get $get): string => '$ '.number_format(HasTotalsArea::calculateTax($get('items')), 2, '.', ',')
                                ),

                            Forms\Components\Placeholder::make('total')
                                ->label('TOTAL')
                                ->extraAttributes([
                                    'style' => 'font-size: 1.5rem;',
                                    'class' => 'text-right font-bold font-mono',
                                ])
                                ->content(fn (Forms\Get $get): string => '$ '.number_format(HasTotalsArea::calculateTotal($get('items')), 2, '.', ',')
                                ),
                        ])
                        ->columnSpan(1),
                ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }

    private static function createNewClient(array $data): int
    {
        $data['company_id'] = Filament::getTenant()->getKey();
        $data['type'] = EntityType::Client;
        $data['code'] = Entity::getNextCode(EntityType::Client);

        return Entity::create($data)->getKey();
    }

    private static function mutateRepeaterData(array $data): array
    {
        $data['operation'] = InventoryOperation::NoEffect;
        $data['subtotal'] = $data['price'] * $data['quantity'];
        $data['tax'] = $data['subtotal'] * 0.16;
        $data['total'] = $data['subtotal'] + $data['tax'];

        return $data;
    }
}
