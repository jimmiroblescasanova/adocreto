<?php

namespace App\Filament\Resources\InventoryInResource\Pages;

use Illuminate\Support\Str;
use App\Enums\DocumentStatus;
use App\Enums\DocumentTypeEnum;
use App\Traits\CreateActionsOnTop;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\InventoryInResource;

class CreateInventoryIn extends CreateRecord
{
    use CreateActionsOnTop;
    
    protected static string $resource = InventoryInResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = DocumentTypeEnum::InventoryIn;
        $data['user_id'] = Auth::id();
        $data['operation'] = 1;

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->getRecord()->update([
            'subtotal' => $this->getRecord()->items->sum('subtotal'),
            'tax' => $this->getRecord()->items->sum('tax'),
            'total' => $this->getRecord()->items->sum('total'),
            'uuid' => Str::uuid(),
            'status' => DocumentStatus::PLACED,
        ]);
    }
}
