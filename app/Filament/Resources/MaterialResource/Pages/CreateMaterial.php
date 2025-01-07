<?php

namespace App\Filament\Resources\MaterialResource\Pages;

use Filament\Actions;
use App\Traits\CreateActionsOnTop;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\MaterialResource;

class CreateMaterial extends CreateRecord
{
    use CreateActionsOnTop;
    
    protected static string $resource = MaterialResource::class;
}
