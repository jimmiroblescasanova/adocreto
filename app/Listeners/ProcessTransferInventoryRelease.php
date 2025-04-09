<?php

namespace App\Listeners;

use App\Actions\CreateInventoryDocument;
use App\Enums\DocumentType;
use App\Enums\InventoryOperation;
use App\Enums\TransferStatus;
use App\Events\TransferInRoute;
use App\Models\Product;
use App\Models\Transfer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessTransferInventoryRelease
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(TransferInRoute $event): void
    {
        try {
            DB::beginTransaction();
            // Create inventory out document
            $inventoryOut = CreateInventoryDocument::run($event->transfer, DocumentType::InventoryOut);
            // Create inventory out items
            $items = $this->convertItemsToInventoryOut($event->transfer);
            $inventoryOut->items()->createMany($items);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            $event->transfer->update([
                'status' => TransferStatus::Pending,
            ]);

            Log::error($th->getMessage(), [
                'transfer_id' => $event->transfer->id,
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }

    /**
     * Convert items to inventory out
     */
    public function convertItemsToInventoryOut(Transfer $source): array
    {
        return $source->items->map(function ($item) use ($source) {
            $averageCost = Product::find($item->product_id)->calculateAveragePrice($source->warehouse_id);

            return [
                'product_id' => $item->product_id,
                'warehouse_id' => $source->warehouse_id,
                'quantity' => $item->quantity,
                'price' => $averageCost,
                'operation' => InventoryOperation::OUT,
            ];
        })->toArray();
    }
}
