<?php

namespace App\Models;

use App\Enums\IsActiveEnum;
use App\Enums\WarehouseTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected function casts(): array
    {
        return [
            'type' => WarehouseTypeEnum::class,
            'active' => IsActiveEnum::class,
        ];
    }

    /**
     * Scope a query to only include active warehouses.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', IsActiveEnum::YES);
    }

    /**
     * Scope a query to only include warehouses of type 'GENERAL'.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeGeneral(Builder $query): Builder
    {
        return $query->where('type', WarehouseTypeEnum::GENERAL);
    }

    /**
     * Scope a query to only include warehouses of type 'SUPPLIES'.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSupplies(Builder $query): Builder
    {
        return $query->where('type', WarehouseTypeEnum::SUPPLIES);
    }
}
