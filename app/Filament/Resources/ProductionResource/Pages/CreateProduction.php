<?php

namespace App\Filament\Resources\ProductionResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use App\Enums\ProductionStatus;
use App\Traits\CreateActionsOnTop;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProductionResource;

class CreateProduction extends CreateRecord
{
    use CreateActionsOnTop;

    protected static string $resource = ProductionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status'] = ProductionStatus::Pending;
        $data['user_id'] = auth()->id();
        $data['uuid'] = Str::uuid();

        return $data;
    }
}
