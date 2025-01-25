<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasActiveSorting
{
    /**
     * Scope a query to prioritize active records first
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrderByActiveFirst(Builder $query): Builder 
    {
        return $query->orderBy('active', 'desc');
    }
} 