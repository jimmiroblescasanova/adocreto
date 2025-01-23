<?php

namespace App\Listeners;

use App\Models\Document;
use App\Models\Transfer;
use App\Enums\DocumentType;
use Illuminate\Support\Str;
use App\Enums\DocumentStatus;
use App\Enums\TransferStatus;
use App\Enums\InventoryOperation;
use App\Events\TransferHasArrived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateInventoryInForTransfer
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {}

    /**
     * Handle the event.
     */
    public function handle(TransferHasArrived $event): void
    {
        // First we need to get the inventory out document
        $inventoryOut = Document::query()
        ->with('items')
        ->where('external_model', Transfer::class)
        ->where('external_id', $event->transfer->id)
        ->first();

        // Then we create the inventory in document
        $inventoryIn = Document::create([
            'company_id' => $event->tenant->id,
            'type' => DocumentType::InventoryIn,
            'folio' => Document::getNextFolio(DocumentType::InventoryIn),
            'title' => 'Entrada de inventario por traspaso. ID:' . $event->transfer->folio,
            'date' => now(),
            'warehouse_id' => $event->transfer->destination_warehouse_id,
            'status' => DocumentStatus::LOCKED,
            'uuid' => Str::uuid(),
            'external_model' => Transfer::class,
            'external_id' => $event->transfer->id,
            'user_id' => auth()->id(), // TODO: this maybe fail if is queued
        ]);

        // Then we create the inventory in items
        $inventoryOut->items->each(function ($item) use ($inventoryIn, $event) {
            $item->replicate()->fill([
                'document_id' => $inventoryIn->id,
                'warehouse_id' => $event->transfer->destination_warehouse_id,
                'operation' => InventoryOperation::IN,
            ])->save();
        });

        // Finally we update the transfer status
        $event->transfer->update([
            'accepted_by' => auth()->id(),
            'status' => TransferStatus::Delivered,
        ]);
    }
}
