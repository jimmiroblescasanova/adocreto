<?php

namespace App\Filament\Resources\MaterialResource\Forms;

use Filament\Forms;
use App\Enums\IsActive;
use Filament\Forms\Form;
use App\Filament\Resources\CategoryResource;

class MaterialForm extends Form 
{
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
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
                    ->label('Estado')
                    ->options(IsActive::class)
                    ->default(true)
                    ->inline(),

                    Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->columnSpanFull(),

                    Forms\Components\Select::make('unit_id')
                    ->label('Unidad')
                    ->relationship(name: 'unit', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->optionsLimit(10)
                    ->selectablePlaceholder(false)
                    ->required(),

                    Forms\Components\TextInput::make('minimum')
                    ->label('Mínimo')
                    ->numeric()
                    ->inputMode('decimal')
                    ->default(0)
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
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->optionsLimit(10)
                    ->createOptionForm(
                        fn ($form) => CategoryResource::form($form)->columns(2)
                    ),

                    Forms\Components\Textarea::make('description')
                    ->label('Descripción')
                    ->rows(5)
                    ->columnSpanFull(),
                ]),
            ])
        ])
        ->columns(3);
    }
}
