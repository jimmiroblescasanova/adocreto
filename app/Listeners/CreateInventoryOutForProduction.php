<?php

namespace App\Listeners;

use App\Models\Product;
use App\Models\Production;
use App\Enums\DocumentType;
use App\Enums\ProductionStatus;
use App\Enums\InventoryOperation;
use App\Events\ProductionStarted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Actions\CreateInventoryDocument;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateInventoryOutForProduction
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductionStarted $event): void
    {
        try {
            DB::beginTransaction();

            $inventoryOut = CreateInventoryDocument::run($event->production, DocumentType::InventoryOut);
            $items = $this->convertComponentsToInventoryOut($event->production);
            $inventoryOut->items()->createMany($items);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            $event->production->update([
                'status' => ProductionStatus::Pending,
            ]);

            Log::error($th->getMessage(), [
                'production_id' => $event->production->id,
                'error' => $th->getMessage()
            ]);

            throw $th;
        }
    }

    /**
     * Convert components to inventory out
     * 
     * @param Production $source
     * @return array
     */
    public function convertComponentsToInventoryOut(Production $source): array
    {
        return $source->components->map(function($component) use ($source) {
            $averageCost = Product::find($component->component_id)->calculateAveragePrice($source->warehouse_id);

            return [
                'product_id' => $component->component_id,
                'warehouse_id' => $source->warehouse_id,
                'quantity' => $component->quantity,
                'price' => $averageCost,
                'operation' => InventoryOperation::OUT,
            ];
        })->toArray();
    }
}
