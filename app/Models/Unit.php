<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use BelongsToTenant;

    /** @use HasFactory<\Database\Factories\UnitFactory> */
    use HasFactory;

    /**
     * Get the products associated with the unit.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
