<?php

namespace App\Filament\Resources\EstimateResource\Pages;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\EstimateResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class PrintEstimate extends Page
{
    use InteractsWithRecord;

    protected static string $resource = EstimateResource::class;

    protected static string $view = 'filament.resources.estimate-resource.pages.print-estimate';

    protected static ?string $title = 'Imprimir cotización';

    public string $pdfUrl;

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->generatePdf();
        $this->pdfUrl = 'storage/pdf/printable.pdf';
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

    private function generatePdf(): void
    {
        $folder = storage_path('app/public/pdf');
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $pdf = Pdf::loadView('pdf.estimate', [
            'estimate' => $this->record,
        ]);
        
        $pdf->save($folder . '/printable.pdf');
    }
}
