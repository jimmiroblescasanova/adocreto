<?php

namespace App\Filament\Resources\MaterialResource\Forms;

use Filament\Forms;
use Filament\Forms\Form;

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

                    Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required(),

                    Forms\Components\Select::make('unit_id')
                    ->label('Unidad')
                    ->relationship(name: 'unit', titleAttribute: 'name')
                    ->required(),

                    Forms\Components\TextInput::make('minumum')
                    ->label('Mínimo')
                    ->numeric()
                    ->inputMode('decimal'),
                ]),

                Forms\Components\Section::make('Datos adicionales')
                ->schema([
                    Forms\Components\Textarea::make('description')
                    ->label('Descripción')
                    ->columnSpanFull(),
                ]),
            ]), 
        ]);
    }
}
