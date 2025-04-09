<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use BelongsToTenant;

    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    /**
     * Get the products associated with the category.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
