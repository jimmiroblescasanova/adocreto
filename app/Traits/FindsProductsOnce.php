<?php

namespace App\Traits;

use App\Models\Product;

trait FindsProductsOnce
{
    public static function getProduct(int $productId): Product
    {
        return once(fn () => Product::find($productId));
    }
}