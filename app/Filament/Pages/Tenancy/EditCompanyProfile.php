<?php

namespace App\Filament\Pages\Tenancy;

use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;

class EditCompanyProfile extends EditTenantProfile 
{
    public static function getLabel(): string
    {
        return 'Editar empresa';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos de la empresa')
                ->description('Información general de la empresa')
                ->aside()
                ->schema([
                    Forms\Components\TextInput::make('name')
                    ->label('Razon social')
                    ->required(),

                    Forms\Components\TextInput::make('rfc')
                    ->label('RFC')
                    ->maxLength(13)
                    ->required(),
                ]),

                Forms\Components\Section::make('Dirección')
                ->description('Dirección fiscal de la empresa')
                ->aside()
                ->schema([
                    Forms\Components\TextInput::make('address')
                    ->label('Dirección completa'),

                    Forms\Components\TextInput::make('zip_code')
                    ->label('Código postal')
                    ->numeric()
                    ->length(5),
                    
                ]),

                Forms\Components\Section::make('Logo')
                ->description('Logo de la empresa, se usara en documentos digitales')
                ->aside()
                ->schema([
                    SpatieMediaLibraryFileUpload::make('logo')
                    ->label('Logotipo')
                    ->collection('company')
                    ->image()
                    ->maxSize(200),
                ]),

                Forms\Components\Section::make('Configuración')
                ->description('Configuración de impuestos')
                ->aside()
                ->schema([
                    Forms\Components\TextInput::make('tax')
                    ->label('IVA')
                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Se coloca el factor')
                    ->numeric()
                    ->step(0.01)
                    ->default(16),
                ]),
            ]);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['name'] = strtoupper($data['name']);
        $data['rfc'] = strtoupper($data['rfc']);

        return $data;
    }
}
