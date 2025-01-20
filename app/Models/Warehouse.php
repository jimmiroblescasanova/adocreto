<?php

namespace App\Models;

use App\Enums\IsActiveEnum;
use App\Enums\WarehouseType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory;
    
    protected function casts(): array
    {
        return [
            'type' => WarehouseType::class,
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
        return $query->where('type', WarehouseType::GENERAL);
    }

    /**
     * Scope a query to only include warehouses of type 'SUPPLIES'.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSupplies(Builder $query): Builder
    {
        return $query->where('type', WarehouseType::SUPPLIES);
    }

    public static function getGroupedOptions(): array
    {
        // Obtener solo almacenes activos y ordenados por nombre
        $warehouses = self::active()
            ->orderBy('name')
            ->get();

        // Validar si hay almacenes
        if ($warehouses->isEmpty()) {
            return [];
        }

        // Agrupar las opciones por el label del enum
        return $warehouses
            ->groupBy(function ($warehouse) {
                return $warehouse->type->getLabel(); // Acceso directo al enum gracias al cast
            })
            ->mapWithKeys(function ($group, $typeLabel) {
                return [
                    $typeLabel => $group->mapWithKeys(function ($warehouse) {
                        return [$warehouse->id => $warehouse->name];
                    })->toArray()
                ];
            })
            ->toArray();
    }
}
