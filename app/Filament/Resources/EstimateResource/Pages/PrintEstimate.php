<?php

namespace App\Filament\Resources\EstimateResource\Pages;

use App\Filament\Resources\EstimateResource;
use App\Traits\GeneratesPdfDocument;
use Filament\Actions\Action;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class PrintEstimate extends Page
{
    use GeneratesPdfDocument;
    use InteractsWithRecord;

    protected static string $resource = EstimateResource::class;

    protected static string $view = 'filament.resources.estimate-resource.pages.print-estimate';

    protected static ?string $title = 'Imprimir cotización';

    public function mount(int|string $record): void
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
