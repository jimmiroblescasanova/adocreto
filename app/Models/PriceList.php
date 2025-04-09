<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PriceList extends Model
{
    use BelongsToTenant;

    /** @use HasFactory<\Database\Factories\PriceListFactory> */
    use HasFactory;

    /**
     * Get the products associated with the price list.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, table: 'prices')
            ->using(Price::class)
            ->withPivot(['price'])
            ->withTimestamps();
    }
}
