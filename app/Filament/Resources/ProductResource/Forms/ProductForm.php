<?php

namespace App\Filament\Resources\ProductResource\Forms;

use Filament\Forms;
use App\Enums\IsActive;
use App\Enums\ProductType;
use Filament\Forms\Form;
use CodeWithDennis\SimpleAlert\Components\Forms\SimpleAlert;

class ProductForm extends Form 
{
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            SimpleAlert::make('alert')
            ->warning()
            ->title('Aun no hay componentes en este producto')
            ->columnSpanFull()
            ->hidden(function ($record): bool {
                $isNotFinishedProduct = $record->type != ProductType::FINISHED_PRODUCT;
                
                return $record->hasComponents() || $isNotFinishedProduct;
            }),

            Forms\Components\Group::make([
                Forms\Components\Section::make('Información básica')
                ->schema([
                    Forms\Components\TextInput::make('code')
                    ->label('Código')
                    ->extraAlpineAttributes([
                        'oninput' => 'this.value = this.value.toUpperCase()',
                    ])
                    ->extraAttributes([
                        'onkeydown' => "if (event.key === ' ') return false;",
                    ])
                    ->required(),

                    Forms\Components\Select::make('type')
                    ->label('Tipo')
                    ->options(ProductType::class)
                    ->native(false)
                    ->required(),

                    Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->columnSpanFull(),

                    Forms\Components\Select::make('unit_id')
                    ->label('Unidad')
                    ->relationship(name: 'unit', titleAttribute: 'virtual_label')
                    ->searchable(['name', 'abbreviation'])
                    ->preload()
                    ->optionsLimit(10)
                    ->selectablePlaceholder(false)
                    ->required(),
                ])
                ->columns(),
            ])
            ->columnSpan(2),

            Forms\Components\Group::make([
                Forms\Components\Section::make('Datos adicionales')
                ->schema([
                    Forms\Components\ToggleButtons::make('active')
                    ->label('Estado')
                    ->options(IsActive::class)
                    ->inline()
                    ->hiddenOn('create'),

                    Forms\Components\Select::make('category_id')
                    ->label('Categoría')
                    ->relationship(name: 'category', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->optionsLimit(10),

                    Forms\Components\Textarea::make('description')
                    ->label('Descripción')
                    ->rows(5),
                ]),
            ]),
        ])
        ->columns(3);
    }
}
