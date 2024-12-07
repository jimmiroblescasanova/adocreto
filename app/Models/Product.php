<?php

namespace App\Models;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    public function price_lists(): BelongsToMany
    {
        return $this->belongsToMany(PriceList::class, table: 'prices')
        ->withPivot(['price'])
        ->withTimestamps();
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * It returns the prices of the product in an array.
     *
     * @return array
     */
    public function prices(): array
    {
        return $this
        ->price_lists
        ->whereBelongsTo(Filament::getTenant())
        ->pluck('pivot.price', 'id')->toArray();
    }
}
