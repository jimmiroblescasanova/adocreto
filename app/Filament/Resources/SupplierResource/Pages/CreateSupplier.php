<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use App\Enums\EntityType;
use App\Filament\Resources\SupplierResource;
use App\Models\Entity;
use App\Traits\CreateActionsOnTop;
use Filament\Resources\Pages\CreateRecord;

class CreateSupplier extends CreateRecord
{
    use CreateActionsOnTop;

    protected static string $resource = SupplierResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['code'] = Entity::getNextCode(EntityType::Supplier);
        $data['type'] = EntityType::Supplier;

        return $data;
    }
}
