<?php

namespace App\Filament\Resources\ProductResource\Forms;

use Filament\Forms;
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
            ->hiddenOn('create')
            ->hidden(fn ($record) => $record->components()->exists()),

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

                    Forms\Components\ToggleButtons::make('active')
                    ->label('Activo')
                    ->boolean()
                    ->inline()
                    ->hiddenOn('create'),

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
