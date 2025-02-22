<?php

namespace App\Listeners;

use App\Enums\DocumentType;
use App\Enums\TransferStatus;
use App\Events\TransferInRoute;
use App\Traits\HasItemsConversion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Actions\CreateInventoryDocument;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessTransferInventoryRelease
{
    use HasItemsConversion;

    /**
     * Create the event listener.
     */
    public function __construct() { }

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
                'error' => $th->getMessage()
            ]);

            throw $th;
        }
    }
}
