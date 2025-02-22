<?php

namespace App\Listeners;

use App\Enums\DocumentType;
use App\Enums\TransferStatus;
use App\Events\TransferHasArrived;
use App\Traits\HasItemsConversion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Actions\CreateInventoryDocument;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessTransferInventoryArrival
{
    use HasItemsConversion;

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
}
