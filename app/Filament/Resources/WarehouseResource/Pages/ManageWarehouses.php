<?php

namespace App\Filament\Resources\WarehouseResource\Pages;

use App\Filament\Resources\WarehouseResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Str;

class ManageWarehouses extends ManageRecords
{
    protected static string $resource = WarehouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['code'] = Str::upper($data['code']);
                    $data['name'] = Str::title($data['name']);

                    return $data;
                }),
        ];
    }
}
