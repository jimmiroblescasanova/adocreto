<?php 

namespace App\Traits;

use Barryvdh\DomPDF\Facade\Pdf;

trait GeneratesPdfDocument
{
    public string $pdfUrl;

    public function generatePdf($document): void
    {
        $template = $this->getTemplate($document);
        $paperSize = $this->getPaperSize($document);

        $folder = storage_path('app/public/pdf');
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $pdf = Pdf::loadView($template, [
            'document' => $this->record,
        ])
        ->setPaper($paperSize, 'portrait');
        
        $pdf->save($folder . "/{$document}.pdf");

        $this->pdfUrl = "storage/pdf/{$document}.pdf";
    }

    private function getTemplate($document): string
    {
        return match ($document) {
            'ticket' => 'pdf.ticket-80mm',
            'estimate' => 'pdf.invoice',
            default => 'pdf.invoice',
        };
    }

    private function getPaperSize($document): string|array
    {
        return match ($document) {
            'ticket' => array(0, 0, 226.77, 850),
            'invoice' => 'letter',
            default => 'letter',
        };
    }
}
