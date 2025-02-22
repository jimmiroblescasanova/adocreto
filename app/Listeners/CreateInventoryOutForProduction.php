<?php

namespace App\Listeners;

use App\Enums\DocumentType;
use App\Events\ProductionStarted;
use App\Actions\CreateInventoryItems;
use App\Actions\CreateInventoryDocument;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

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
            $items = CreateInventoryItems::run($event->production, DocumentType::InventoryOut);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
