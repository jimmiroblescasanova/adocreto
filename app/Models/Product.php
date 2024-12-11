<?php

namespace App\Models;

use App\Enums\IsActiveEnum;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'active' => IsActiveEnum::class,
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function components(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, table: 'product_components')
        ->using(ProductComponent::class)
        ->withPivot(['quantity'])
        ->withTimestamps();
    }

    public function price_lists(): BelongsToMany
    {
        return $this->belongsToMany(PriceList::class, table: 'prices')
        ->using(Price::class)
        ->withPivot(['price'])
        ->withTimestamps();
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
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
