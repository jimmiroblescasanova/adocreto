<?php

namespace App\Models;

use App\Casts\QuantityCast;
use Illuminate\Database\Eloquent\Model;

class ProductionComponent extends Model
{
    protected function casts(): array
    {
        return [
            'quantity' => QuantityCast::class,
        ];
    }

    
}
