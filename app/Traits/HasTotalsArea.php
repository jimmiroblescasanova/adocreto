<?php

namespace App\Traits;

trait HasTotalsArea
{
    public static function calculateSubtotal(array $items): float
    {
        $subtotal = collect($items)->sum(function($item) {
            if (!isset($item['quantity']) || !isset($item['price'])) {
                return 0;
            }
            return ($item['quantity'] * $item['price']);
        });

        return round($subtotal, 2);
    }

    public static function calculateTax(array $items): float
    {
        $subtotal = self::calculateSubtotal($items);
        return round($subtotal * 0.16, 2);
    }

    public static function calculateTotal(array $items): float
    {
        $subtotal = self::calculateSubtotal($items);
        $tax = self::calculateTax($items);
        return round($subtotal + $tax, 2);
    }
}