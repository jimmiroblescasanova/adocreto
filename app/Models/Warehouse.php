<?php

namespace App\Models;

use App\Enums\IsActive;
use App\Enums\WarehouseType;
use App\Traits\BelongsToTenant;
use App\Traits\HasActiveSorting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use BelongsToTenant;
    use HasActiveSorting;
    use HasFactory;

    protected function casts(): array
    {
        return [
            'type' => WarehouseType::class,
            'active' => IsActive::class,
        ];
    }

    /**
     * Scope a query to only include active warehouses.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', IsActive::Yes);
    }

    /**
     * Scope a query to only include warehouses of type 'GENERAL'.
     */
    public function scopeGeneral(Builder $query): Builder
    {
        return $query->where('type', WarehouseType::General);
    }

    /**
     * Scope a query to only include warehouses of type 'SUPPLIES'.
     */
    public function scopeSupplies(Builder $query): Builder
    {
        return $query->where('type', WarehouseType::Supplies);
    }

    /**
     * Get the grouped options for the warehouse.
     */
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
                    })->toArray(),
                ];
            })
            ->toArray();
    }
}
