<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Material extends Model
{
    /** @use HasFactory<\Database\Factories\MaterialFactory> */
    use HasFactory;

    protected $casts = [
        'active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, table: 'product_components')
        ->using(ProductComponent::class)
        ->withPivot(['quantity'])
        ->withTimestamps();
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
