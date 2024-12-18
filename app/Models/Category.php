<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class); 
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class); 
    }
}
