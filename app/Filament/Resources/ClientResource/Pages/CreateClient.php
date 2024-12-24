<?php

namespace App\Filament\Resources\ClientResource\Pages;

use Filament\Actions;
use App\Enums\EntityType;
use App\Traits\CreateActionsOnTop;
use App\Filament\Resources\ClientResource;
use Filament\Resources\Pages\CreateRecord;

class CreateClient extends CreateRecord
{
    use CreateActionsOnTop;
    
    protected static string $resource = ClientResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = EntityType::CLIENT;

        return $data;
    }
}
