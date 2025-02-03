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
        
        $products = $production->items()->get()->map(function ($item) {
            return $item->product->load('components');
        });
    
        // Extraemos todos los component_id de los productos
        $components = $products->flatMap(function ($product) {
            return $product->components->select('component_id', 'quantity');
        });

        $components->each(function ($component) use ($production) {
            // Buscar o crear el registro de componente para la producción
            $record = ProductionComponent::firstOrNew([
                'production_id' => $production->id,
                'component_id' => $component['component_id'],
            ]);

            // Sumar la cantidad anterior (si existe) con la nueva cantidad
            $record->quantity = ($record->quantity ?? 0) + $component['quantity'];
            $record->save();
        });
    }
}
