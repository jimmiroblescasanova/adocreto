<?php

namespace App\Filament\Resources\PriceListResource\Pages;

use App\Filament\Resources\PriceListResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Str;

class ManagePriceLists extends ManageRecords
{
    protected static string $resource = PriceListResource::class;

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
