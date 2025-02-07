<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'tax' => MoneyCast::class,
        ];
    }

    /**
     * Get the categories associated with the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Get the documents associated with the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Entity::class);
    }

    /**
     * Get the entities associated with the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entities(): HasMany
    {
        return $this->hasMany(Entity::class);
    }

    /**
     * Get the transfers associated with the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transfers(): HasMany
    {
        return $this->hasMany(Transfer::class);
    }

    /**
     * Get the price lists associated with the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function priceLists(): HasMany
    {
        return $this->hasMany(PriceList::class);
    }

    /**
     * Get the productions associated with the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productions(): HasMany
    {
        return $this->hasMany(Production::class);
    }

    /**
     * Get the products associated with the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the units associated with the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    /**
     * Get the warehouses associated with the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function warehouses(): HasMany
    {
        return $this->hasMany(Warehouse::class);
    }
}
