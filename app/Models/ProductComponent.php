<?php

namespace App\Models;

use App\Casts\QuantityCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductComponent extends Model
{
    protected $casts = [
        'quantity' => QuantityCast::class,
    ];

    /**
     * Get the product that owns the component.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the component product that the product component belongs to.
     */
    public function component(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'component_id');
    }
}
