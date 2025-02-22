<?php

namespace App\Filament\Resources\ProductionResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use App\Enums\ProductionStatus;
use App\Traits\CreateActionsOnTop;
use App\Models\ProductionComponent;
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
