<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;

class EstimateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Document $document)
    {
        $pdf = Pdf::loadView('pdf.estimate', [
            'estimate' => $document,
        ]);

        return $pdf->stream();
    }
}
