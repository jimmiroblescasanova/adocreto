<?php

namespace App\Filament\Resources\ProductionResource\Pages;

use App\Enums\ProductionStatus;
use App\Filament\Resources\ProductionResource;
use App\Models\ProductionComponent;
use App\Traits\CreateActionsOnTop;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

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

    protected function afterCreate(): void
    {
        $production = $this->record;

        $production->load('items.product.components');

        $production->items->each(function ($item) use ($production) {
            $item->product->components->each(function ($component) use ($item, $production) {
                $record = ProductionComponent::firstOrNew([
                    'production_id' => $production->id,
                    'component_id' => $component->component_id,
                ]);

                $record->quantity += $component->quantity * $item->quantity;
                $record->save();
            });
        });
    }
}
