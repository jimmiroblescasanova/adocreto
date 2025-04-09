<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use App\Traits\GeneratesPdfDocument;
use Filament\Actions\Action;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class PrintSale extends Page
{
    use GeneratesPdfDocument;
    use InteractsWithRecord;

    protected static string $resource = SaleResource::class;

    protected static string $view = 'filament.resources.sale-resource.pages.print-sale';

    protected static ?string $title = 'Imprimir venta';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->generatePdf('ticket');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('backToSale')
                ->label('Volver a la venta')
                ->url(SaleResource::getUrl('view', ['record' => $this->record]))
                ->icon('heroicon-o-arrow-left')
                ->color('success'),
        ];
    }
}
