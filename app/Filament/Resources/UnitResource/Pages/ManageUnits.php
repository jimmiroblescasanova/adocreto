<?php

namespace App\Filament\Resources\UnitResource\Pages;

use Filament\Actions;
use App\Filament\Resources\UnitResource;
use Filament\Resources\Pages\ManageRecords;

class ManageUnits extends ManageRecords
{
    protected static string $resource = UnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->mutateFormDataUsing(function (array $data): array {
                $data['name'] = strtoupper($data['name']);
                $data['abbreviation'] = strtoupper($data['abbreviation']);
         
                return $data;
            }),
        ];
    }
}
