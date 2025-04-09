<?php

namespace App\Models;

use App\Casts\QuantityCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransferItem extends Model
{
    protected function casts(): array
    {
        return [
            'quantity' => QuantityCast::class,
        ];
    }

    /**
     * This method returns the transfer for the item.
     *
     * @return BelongsTo<Transfer>
     */
    public function transfer(): BelongsTo
    {
        return $this->belongsTo(Transfer::class);
    }

    /**
     * This method returns the product for the item.
     *
     * @return BelongsTo<Product>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
