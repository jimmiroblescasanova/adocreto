<?php

namespace App\Filament\Resources\ClientResource\Forms;

use Filament\Forms;
use App\Enums\IsActive;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Illuminate\Support\Str;
use App\Models\Cfdi40\UsoCfdi;
use App\Models\Cfdi40\RegimenFiscal;
use App\Filament\Resources\EstimateResource\Pages\CreateEstimate;

class ClientForm extends Form 
{
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Section::make('Información del cliente')
            ->icon('heroicon-o-user')
            ->schema([
                Forms\Components\ToggleButtons::make('is_fiscal')
                ->label('Tipo de cliente')
                ->options([
                    0 => 'Fiscal',
                    1 => 'No fiscal',
                ])
                ->default(0)
                ->inline()
                ->live()
                ->afterStateHydrated(function (Forms\Get $get, Forms\Set $set) {
                    $set('is_fiscal', $get('rfc') ? 0 : 1);
                })
                ->dehydrated(false),

                Forms\Components\TextInput::make('rfc')
                ->label('RFC')
                ->validationAttribute('rfc')
                ->hintIcon(icon: 'heroicon-m-question-mark-circle', tooltip: 'Captura sin guiones')
                ->minLength(12)
                ->maxLength(13)
                ->required(fn (Forms\Get $get) => !$get('is_fiscal'))
                ->disabled(fn (Forms\Get $get) => $get('is_fiscal'))
                ->unique(ignoreRecord: true)
                ->dehydrateStateUsing(function (Forms\Get $get, string $state) {
                    if ($get('is_fiscal') === 1) {
                        $state = '';
                    }

                    return $state;
                })
                ->live(),

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

                Forms\Components\Fieldset::make('Datos CFDi')
                ->schema([
                    Forms\Components\Select::make('regimen_fiscal_id')
                    ->label('Régimen Fiscal')
                    ->options(function (Get $get) {
                        return match (Str::length($get('rfc'))) {
                            12 => RegimenFiscal::moral()->pluck('descripcion', 'id'),
                            13 => RegimenFiscal::fisica()->pluck('descripcion', 'id'),
                            default => [],
                        };
                    })
                    ->preload()
                    ->searchable()
                    ->native(false), 

                    Forms\Components\Select::make('uso_cfdi_id')
                    ->label('Uso del CFDi')
                    ->options(function (Get $get) {
                        return match (Str::length($get('rfc'))) {
                            12 => UsoCfdi::moral()->pluck('descripcion', 'id'),
                            13 => UsoCfdi::fisica()->pluck('descripcion', 'id'),
                            default => [],
                        };
                    })
                    ->preload()
                    ->searchable()
                    ->native(false), 
                ])
                ->hidden(fn (Forms\Get $get) => $get('is_fiscal')),
            ])
            ->columns()
            ->columnSpan(function (string $operation) {
                return match ($operation) {
                    'create' => 2,
                    'edit' => 2,
                    default => 3,
                };
            }),

            Forms\Components\Section::make('Información adicional')
            ->icon('heroicon-o-information-circle')
            ->schema([
                Forms\Components\ToggleButtons::make('active')
                ->label('Estado')
                ->options(IsActive::class)
                ->inline()
                ->hiddenOn('create'),

                Forms\Components\Textarea::make('notes')
                ->label('Notas adicionales')
                ->rows(3),
            ])
            ->hiddenOn(CreateEstimate::class)
            ->columnSpan(1),
        ])
        ->columns(3);
    }
}
