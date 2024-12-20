<?php

namespace App\Models;

use App\Enums\IsActiveEnum;
use App\Enums\WarehouseTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected function casts(): array
    {
        return [
            'type' => WarehouseTypeEnum::class,
            'active' => IsActiveEnum::class,
        ];
    }
}
