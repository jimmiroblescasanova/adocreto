<?php

namespace App\Filament\Resources\InventoryInResource\Pages;

use Filament\Actions;
use App\Models\Document;
use Illuminate\Support\Str;
use App\Enums\DocumentTypeEnum;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\InventoryInResource;

class CreateInventoryIn extends CreateRecord
{
    protected static string $resource = InventoryInResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = DocumentTypeEnum::InventoryIn;
        $data['user_id'] = Auth::id();

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->getRecord()->update([
            'uuid' => Str::uuid(),
        ]);
    }
}
