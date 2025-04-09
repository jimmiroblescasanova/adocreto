<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Str;

class ManageCategories extends ManageRecords
{
    protected static string $resource = CategoryResource::class;

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
