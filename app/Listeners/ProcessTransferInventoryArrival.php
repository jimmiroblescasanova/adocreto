<?php

namespace App\Listeners;

use App\Models\Product;
use App\Models\Transfer;
use App\Enums\DocumentType;
use App\Enums\TransferStatus;
use App\Enums\InventoryOperation;
use App\Events\TransferHasArrived;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Actions\CreateInventoryDocument;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessTransferInventoryArrival
{
    /**
     * Create the event listener.
     */
    public function __construct() { }

    /**
     * Handle the event.
     */
    public function handle(TransferHasArrived $event): void
    {
        try {
            DB::beginTransaction();
            $inventoryIn = CreateInventoryDocument::run($event->transfer, DocumentType::InventoryIn);
            
            $items = $this->convertItemsToInventoryIn($event->transfer);
            $inventoryIn->items()->createMany($items);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            $event->transfer->update([
                'status' => TransferStatus::Pending,
                'accepted_by' => null,
            ]);

            Log::error($th->getMessage(), [
                'transfer_id' => $event->transfer->id,
                'error' => $th->getMessage()
            ]);

            throw $th;
        }
    }

    /**
     * Convert items to inventory in
     * 
     * @param Transfer $source
     * @return array
     */
    public function convertItemsToInventoryIn(Transfer $source): array
    {
        return $source->items->map(function($item) use ($source) {
            $averageCost = Product::find($item->product_id)->calculateAveragePrice($source->warehouse_id);

            return [
                'product_id' => $item->product_id,
                'warehouse_id' => $source->destination_warehouse_id,
                'quantity' => $item->quantity,
                'price' => $averageCost,
                'operation' => InventoryOperation::IN,
            ];
        })->toArray();
    }
}
