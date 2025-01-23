<?php

namespace App\Listeners;

use Throwable;
use App\Models\Product;
use App\Models\Document;
use App\Models\Transfer;
use App\Enums\DocumentType;
use Illuminate\Support\Str;
use App\Enums\DocumentStatus;
use App\Enums\TransferStatus;
use App\Events\TransferInRoute;
use App\Enums\InventoryOperation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateInventoyOutForTransfer
{
    /**
     * Create the event listener.
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TransferInRoute $event): void
    {
        try {
            DB::beginTransaction();
            // Create inventory out document
            $inventoryOut = Document::create([
                'company_id' => $event->company->id,
                'type' => DocumentType::InventoryOut,
                'user_id' => $event->transfer->created_by,
                'warehouse_id' => $event->transfer->origin_warehouse_id,
                'date' => now(),
                'folio' => Document::getFolio(DocumentType::InventoryOut) + 1,
                'title' => "Salida de inventario por traspaso. [ID#{$event->transfer->folio}]",
                'status' => DocumentStatus::LOCKED,
                'uuid' => Str::uuid(),
                'external_model' => Transfer::class,
                'external_id' => $event->transfer->id,
            ]);

            // Create inventory out items
            $items = $this->generateItemsArray($event->transfer, $inventoryOut->id);
            $inventoryOut->items()->createMany($items);

            // Update inventory out total
            $inventoryOut->update([
                'total' => collect($items)->sum('price'),
            ]);
    
            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();

            $event->transfer->update([
                'status' => TransferStatus::Pending,
            ]);
            
            Log::error($th->getMessage());
        }
    }

    private function generateItemsArray(Transfer $transfer, int $inventoryOutId): array
    {
        return $transfer->items->map(function($item) use ($inventoryOutId, $transfer) {
            $averageCost = Product::find($item->product_id)->calculateAveragePrice($transfer->origin_warehouse_id);

            return [
                'document_id' => $inventoryOutId,
                'product_id' => $item->product_id,
                'warehouse_id' => $transfer->origin_warehouse_id,
                'quantity' => $item->quantity,
                'price' => $averageCost,
                'operation' => InventoryOperation::OUT,
            ];
        })->toArray();
    }
}
