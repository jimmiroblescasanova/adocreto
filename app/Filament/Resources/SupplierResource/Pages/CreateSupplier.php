<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use Filament\Actions;
use App\Enums\EntityType;
use App\Traits\CreateActionsOnTop;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\SupplierResource;

class CreateSupplier extends CreateRecord
{
    use CreateActionsOnTop;
    
    protected static string $resource = SupplierResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = EntityType::SUPPLIER;

        return $data;
    }
}
