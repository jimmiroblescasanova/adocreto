<?php

namespace App\Models;

use App\Enums\IsActive;
use App\Enums\ProductType;
use App\Casts\QuantityCast;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    use BelongsToTenant;

    protected function casts(): array
    {
        return [
            'type'      => ProductType::class,
            'mininum'   => QuantityCast::class,
            'active'    => IsActive::class,
        ];
    }

    /**
     * Get the category that owns the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the document items associated with the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documentItems(): HasMany
    {
        return $this->hasMany(DocumentItem::class);
    }

    /**
     * Get the components associated with the product.
     * 
     * This establishes a one-to-many relationship between the Product model
     * and the ProductComponent model, allowing access to all components
     * that belong to this product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function components(): HasMany
    {
        return $this->hasMany(ProductComponent::class);
    }

    /**
     * Get the price lists associated with the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function price_lists(): BelongsToMany
    {
        return $this->belongsToMany(PriceList::class, table: 'prices')
        ->using(Price::class)
        ->withPivot(['price'])
        ->withTimestamps();
    }

    /**
     * Get the Unit that this Product belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Calculate the average price of the product for a specific warehouse.
     *
     * @param int|null $warehouseId
     * @return int
     */
    public function calculateAveragePrice(?int $warehouseId = null): int
    {
        return $this->documentItems()
            ->when($warehouseId, function ($query) use ($warehouseId) {
                $query->where('warehouse_id', $warehouseId);
            })
            ->average('price') / 100 ?? 0;
    }


    /**
     * Calculate the inventory of the product for a specific warehouse.
     *
     * @param int|null $warehouseId
     * @return int
     */
    public function totalInventory(?int $warehouseId = null): int
    {
        return $this->documentItems()
            ->when($warehouseId, function ($query) use ($warehouseId) {
                $query->where('warehouse_id', $warehouseId);
            })
            ->selectRaw('SUM(quantity * operation) as total')
            ->value('total') ?? 0;
    }

    /**
     * Scope query to only include products of type material.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMaterials(Builder $query): Builder
    {
        return $query->where('type', ProductType::MATERIAL);
    }

    /**
     * Scope query to only include products of type PRODUCT.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProducts(Builder $query): Builder
    {
        return $query->where('type', '!=', ProductType::MATERIAL);
    }

    /**
     * Check if the product has components.
     *
     * @return bool
     */
    public function hasComponents(): bool
    {
        return $this->components()->exists();
    }
}
