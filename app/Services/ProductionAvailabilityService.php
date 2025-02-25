<?php

namespace App\Services;

use App\Models\Production;
use App\Models\ProductionComponent;

class ProductionAvailabilityService
{
    public function canBeProduced(Production $production): bool
    {
        return $production->components->every(function (ProductionComponent $component) use ($production) {
            return $component->product->totalInventory($production->warehouse_id) >= $component->quantity;
        });
    }

    public function getUnavailableComponents(Production $production): array
    {
        return $production->components
            ->filter(function (ProductionComponent $component) use ($production) {
                return $component->product->totalInventory($production->warehouse_id) < $component->quantity;
            })
            ->map(function (ProductionComponent $component) use ($production) {
                return [
                    'product' => $component->product->name,
                    'required' => $component->quantity,
                    'available' => $component->product->totalInventory($production->warehouse_id)
                ];
            })
            ->toArray();
    }
} 