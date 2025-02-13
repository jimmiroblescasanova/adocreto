<?php

namespace App\Filament\Resources\ProductResource\Forms;

use Filament\Forms;
use App\Enums\IsActive;
use Filament\Forms\Form;
use App\Enums\ProductType;
use Filament\Facades\Filament;
use Illuminate\Validation\Rules\Unique;

class ProductForm extends Form 
{
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Group::make([
                Forms\Components\Section::make('Información básica')
                ->schema([
                    Forms\Components\Select::make('type')
                    ->label('Tipo')
                    ->options(ProductType::getOptions())
                    ->native(false)
                    ->required()
                    ->live(onBlur: true)
                    ->disabledOn('edit'),

                    Forms\Components\TextInput::make('code')
                    ->label('Código')
                    ->extraAlpineAttributes([
                        'oninput' => 'this.value = this.value.toUpperCase()',
                    ])
                    ->extraAttributes([
                        'onkeydown' => "if (event.key === ' ') return false;",
                    ])
                    ->required()
                    ->unique(ignoreRecord: true, modifyRuleUsing: function (Unique $rule) {
                        return $rule->where('company_id', Filament::getTenant()->id)
                            ->where('type', '!=', ProductType::Material);
                    }),

                    Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->columnSpanFull(),

                    Forms\Components\Textarea::make('description')
                    ->label('Descripción')
                    ->rows(4)
                    ->columnSpanFull(),

                    Forms\Components\Select::make('unit_id')
                    ->label('Unidad de venta')
                    ->relationship(name: 'unit', titleAttribute: 'virtual_label')
                    ->searchable(['name', 'abbreviation'])
                    ->preload()
                    ->optionsLimit(10)
                    ->selectablePlaceholder(false)
                    ->required(),

                    Forms\Components\Fieldset::make('Producción')
                    ->schema([
                        Forms\Components\TextInput::make('production_conversion_quantity')
                        ->label('Cantidad de conversión')
                        ->numeric()
                        ->inputMode('decimal')
                        ->default(1)
                        ->required(),

                        Forms\Components\Select::make('production_unit_id')
                        ->label('Unidad de producción')
                        ->relationship(name: 'production_unit', titleAttribute: 'name')
                        ->native(false)
                        ->searchable()
                        ->preload()
                        ->optionsLimit(10),
                    ])
                    ->visible(function(Forms\Get $get): bool {
                        $type = $get('type');
                        return $type == ProductType::FinishedProduct->value;
                    }),
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
