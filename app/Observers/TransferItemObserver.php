<?php

namespace App\Observers;

use App\Models\DocumentItem;
use App\Models\TransferItem;
use App\Enums\InventoryOperation;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class TransferItemObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the TransferItem "created" event.
     */
    public function created(TransferItem $transferItem): void
    {
        $id = $transferItem->transfer->id;
        $originWarehouse = $transferItem->transfer->origin_warehouse_id;
        $destinationWarehouse = $transferItem->transfer->destination_warehouse_id;

        // Create document items for origin and destination warehouses
        DocumentItem::create([
            'product_id' => $transferItem->product_id,
            'warehouse_id' => $originWarehouse,
            'quantity' => $transferItem->quantity,
            'operation' => InventoryOperation::OUT,
            'transfer_id' => $id,
        ], [
            'product_id' => $transferItem->product_id,
            'warehouse_id' => $destinationWarehouse,
            'quantity' => $transferItem->quantity,
            'operation' => InventoryOperation::IN,
            'transfer_id' => $id,
        ]);

    }

    /**
     * Handle the TransferItem "updated" event.
     */
    public function updated(TransferItem $transferItem): void
    {
        // TODO: Update document items for origin and destination warehouses
    }

    /**
     * Handle the TransferItem "deleted" event.
     */
    public function deleted(TransferItem $transferItem): void
    {
        //
    }

    /**
     * Handle the TransferItem "restored" event.
     */
    public function restored(TransferItem $transferItem): void
    {
        //
    }

    /**
     * Handle the TransferItem "force deleted" event.
     */
    public function forceDeleted(TransferItem $transferItem): void
    {
        //
    }
}
