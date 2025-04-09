<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Exports\SaleExporter;
use App\Filament\Resources\SaleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSales extends ListRecords
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\ExportAction::make()
                ->label('Exportar ventas')
                ->exporter(
                    SaleExporter::class
                )
                ->columnMapping(false)
                ->modalHeading('Exportar ventas'),
        ];
    }
}
