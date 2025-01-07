<?php

namespace App\Filament\Resources\WarehouseResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\WarehouseResource;

class ManageWarehouses extends ManageRecords
{
    protected static string $resource = WarehouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->mutateFormDataUsing(function (array $data): array {
                $data['name'] = Str::title($data['name']);

                return $data;
            }),
        ];
    }
}
