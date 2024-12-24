<?php

namespace App\Filament\Resources\ClientResource\Forms;

use Filament\Forms;
use Filament\Forms\Form;

class ClientForm extends Form 
{
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Section::make('Información del cliente')
            ->schema([
                Forms\Components\TextInput::make('code')
                ->label('Código')
                ->required()
                ->maxLength(255),

                Forms\Components\TextInput::make('rfc')
                ->label('RFC')
                ->hintIcon(icon: 'heroicon-m-question-mark-circle', tooltip: 'Captura sin guiones')
                ->minLength(12)
                ->maxLength(13),

                Forms\Components\TextInput::make('name')
                ->label('Nombre del cliente')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

                Forms\Components\TextInput::make('email')
                ->email()
                ->maxLength(255),

                Forms\Components\TextInput::make('phone')
                ->label('Teléfono')
                ->tel(),
            ])
            ->columns()
            ->columnSpan(2),

            Forms\Components\Section::make('Información adicional')
            ->schema([
                Forms\Components\ToggleButtons::make('active')
                ->label('Activo')
                ->boolean()
                ->inline()
                ->hiddenOn('create'),

                Forms\Components\Textarea::make('notes')
                ->label('Notas adicionales')
                ->rows(3),
            ])
            ->columnSpan(1),
        ])
        ->columns(3);
    }
}
