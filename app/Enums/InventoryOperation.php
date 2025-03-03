<?php

namespace App\Enums;

enum InventoryOperation: int
{
    case IN = 1;
    case OUT = -1;
    case NoEffect = 0;
}
