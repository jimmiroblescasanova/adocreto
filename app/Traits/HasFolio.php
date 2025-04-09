<?php

namespace App\Traits;

trait HasFolio
{
    /**
     * Returns the last folio number used.
     */
    public static function getFolio(): int
    {
        return (int) self::query()->max('folio') ?? 0;
    }

    /**
     * Returns the next available folio number.
     */
    public static function getNextFolio(): int
    {
        return self::getFolio() + 1;
    }
}
