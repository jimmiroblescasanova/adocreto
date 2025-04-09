<?php

namespace App\Filament\Exports;

use App\Models\Document;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class SaleExporter extends Exporter
{
    protected static ?string $model = Document::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('date')
                ->label('Fecha'),

            ExportColumn::make('folio')
                ->label('Folio'),

            ExportColumn::make('entity.name')
                ->label('Cliente'),

            ExportColumn::make('title')
                ->label('Título'),

            ExportColumn::make('subtotal')
                ->label('Subtotal'),

            ExportColumn::make('tax')
                ->label('Impuesto'),

            ExportColumn::make('total')
                ->label('Total'),

            ExportColumn::make('doc_status')
                ->label('Estado')
                ->formatStateUsing(fn (Document $record): string => $record->status->getLabel()),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'La descarga de las ventas ha terminado y '.number_format($export->successful_rows).' '.str('fila')->plural($export->successful_rows).' fueron exportadas.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('fila')->plural($failedRowsCount).' no se pudieron exportar.';
        }

        return $body;
    }
}
