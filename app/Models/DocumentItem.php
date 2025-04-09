<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Casts\QuantityCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentItem extends Model
{
    protected function casts(): array
    {
        return [
            'quantity' => QuantityCast::class,
            'price' => MoneyCast::class,
            'subtotal' => MoneyCast::class,
            'tax' => MoneyCast::class,
            'total' => MoneyCast::class,
        ];
    }

    /**
     * Get the document that owns the item.
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    /**
     * Get the product that owns the item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the warehouse that owns the item.
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
