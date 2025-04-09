<?php

namespace App\Models;

use App\Casts\QuantityCast;
use App\Enums\IsActive;
use App\Enums\ProductType;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use BelongsToTenant;

    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    use InteractsWithMedia;

    protected function casts(): array
    {
        return [
            'type' => ProductType::class,
            'mininum' => QuantityCast::class,
            'active' => IsActive::class,
        ];
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the document items associated with the product.
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
     */
    public function components(): HasMany
    {
        return $this->hasMany(ProductComponent::class);
    }

    /**
     * Get the price lists associated with the product.
     */
    public function price_lists(): BelongsToMany
    {
        return $this->belongsToMany(PriceList::class, table: 'prices')
            ->using(Price::class)
            ->withPivot(['price'])
            ->withTimestamps();
    }

    /**
     * Get the production unit that this Product belongs to
     */
    public function production_unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'production_unit_id');
    }

    /**
     * Get the Unit that this Product belongs to
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Calculate the average price of the product for a specific warehouse.
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
     */
    public function scopeMaterials(Builder $query): Builder
    {
        return $query->where('type', ProductType::Material);
    }

    /**
     * Scope query to only include products of type PRODUCT.
     */
    public function scopeProducts(Builder $query): Builder
    {
        return $query->where('type', '!=', ProductType::Material);
    }

    /**
     * Check if the product has components.
     */
    public function hasComponents(): bool
    {
        return $this->components()->exists();
    }
}
