<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Enums\EntityType;
use App\Filament\Resources\ClientResource;
use App\Models\Entity;
use App\Traits\CreateActionsOnTop;
use Filament\Resources\Pages\CreateRecord;

class CreateClient extends CreateRecord
{
    use CreateActionsOnTop;

    protected static string $resource = ClientResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['code'] = Entity::getNextCode(EntityType::Client);
        $data['type'] = EntityType::Client;

        return $data;
    }
}
