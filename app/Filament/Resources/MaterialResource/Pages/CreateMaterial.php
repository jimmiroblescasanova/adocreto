<?php

namespace App\Filament\Resources\MaterialResource\Pages;

use App\Enums\ProductType;
use App\Filament\Resources\MaterialResource;
use App\Traits\CreateActionsOnTop;
use Filament\Resources\Pages\CreateRecord;

class CreateMaterial extends CreateRecord
{
    use CreateActionsOnTop;

    protected static string $resource = MaterialResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = ProductType::Material;

        return $data;
    }
}
