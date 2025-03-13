<?php

namespace App\Filament\Resources\EstimateResource\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\EstimateResource;
use App\Traits\GeneratesPdfDocument;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class PrintEstimate extends Page
{
    use InteractsWithRecord;
    use GeneratesPdfDocument;

    protected static string $resource = EstimateResource::class;

    protected static string $view = 'filament.resources.estimate-resource.pages.print-estimate';

    protected static ?string $title = 'Imprimir cotización';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->generatePdf('invoice');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('backEstimate')
                ->label('Volver a la cotización')
                ->url(EstimateResource::getUrl('view', ['record' => $this->record]))
                ->icon('heroicon-o-arrow-left')
                ->color('success'),
        ];
    }
}
