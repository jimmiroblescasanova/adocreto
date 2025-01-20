<?php

namespace App\Models;

use App\Casts\QuantityCast;
use App\Observers\TransferItemObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([TransferItemObserver::class])]
class TransferItem extends Model
{
    protected function casts(): array
    {
        return [
            'quantity' => QuantityCast::class,
        ];
    }

    /**
     * Get the product that owns the transfer item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the transfer that owns the transfer item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transfer(): BelongsTo
    {
        return $this->belongsTo(Transfer::class);
    }
}
