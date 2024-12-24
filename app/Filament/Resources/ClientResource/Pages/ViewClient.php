<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Components\Actions\BackButton;
use App\Filament\Resources\ClientResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewClient extends ViewRecord
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            BackButton::make(),
        ];
    }
}
