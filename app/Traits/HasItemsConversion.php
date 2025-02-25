<?php 

namespace App\Traits;

use App\Models\Product;
use App\Models\Transfer;
use App\Models\Production;
use App\Enums\InventoryOperation;

trait HasItemsConversion
{
    /**
     * Convert items to inventory out
     * 
     * @param Transfer $source
     * @return array
     */
    public function convertItemsToInventoryOut(Transfer $source): array
    {
        return $source->items->map(function($item) use ($source) {
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
