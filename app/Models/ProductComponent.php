<?php

namespace App\Models;

use App\Casts\QuantityCast;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductComponent extends Pivot
{
    protected $table = 'product_components';
    
    protected $casts = [
        'quantity' => QuantityCast::class,
    ];
}
