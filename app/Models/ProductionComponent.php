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

    /**
     * This method returns the product that the production component belongs to.
     *
     * @return BelongsTo<Product>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'component_id');
    }

    /**
     * This method returns the production that the production component belongs to.
     *
     * @return BelongsTo<Production>
     */
    public function production(): BelongsTo
    {
        return $this->belongsTo(Production::class);
    }
}
