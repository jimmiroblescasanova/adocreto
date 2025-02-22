<?php

namespace App\Models;

use App\Casts\QuantityCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductionComponent extends Model
{
    protected function casts(): array
    {
        return [
            'quantity' => QuantityCast::class,
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'component_id');
    }
}
