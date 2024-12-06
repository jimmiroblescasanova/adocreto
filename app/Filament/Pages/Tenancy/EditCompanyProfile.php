<?php

namespace App\Filament\Pages\Tenancy;

use Filament\Forms; 
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
                Forms\Components\TextInput::make('name')
                ->label('Razon social'),

                Forms\Components\TextInput::make('rfc')
                ->label('RFC')
                ->maxLength(13),
            ]);
    }
}
