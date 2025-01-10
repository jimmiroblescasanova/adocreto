<?php

namespace App\Filament\Resources\SupplierResource\Forms;

use Filament\Forms;
use Filament\Forms\Form;

class SupplierForm extends Form 
{
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Section::make('Información General')
            ->schema([
                Forms\Components\TextInput::make('code')
                ->label('Código')
                ->minLength(3)
                ->required(),

                Forms\Components\TextInput::make('rfc')
                ->label('RFC')
                ->minLength(12)
                ->maxLength(13),

                Forms\Components\TextInput::make('name')
                ->label('Nombre')
                ->maxLength(255)
                ->required()
                ->columnSpanFull(),
            ])
            ->columns()
            ->columnSpan(2),

            Forms\Components\Section::make('Adicionales')
            ->schema([
                Forms\Components\Textarea::make('notes')
                ->label('Notas')
                ->rows(3),
            ])
            ->columnSpan(1)
        ])
        ->columns(3);
    }
}
