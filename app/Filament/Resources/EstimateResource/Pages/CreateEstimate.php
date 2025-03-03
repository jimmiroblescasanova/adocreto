<?php

namespace App\Filament\Resources\EstimateResource\Pages;

use Filament\Actions;
use App\Enums\DocumentType;
use Illuminate\Support\Str;
use App\Enums\DocumentStatus;
use App\Traits\HasTotalsArea;
use App\Traits\CreateActionsOnTop;
use App\Traits\ManageProductsFromModal;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\EstimateResource;

class CreateEstimate extends CreateRecord
{
    use ManageProductsFromModal;
    use CreateActionsOnTop;
    use HasTotalsArea;

    protected static string $resource = EstimateResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $subtotal = HasTotalsArea::calculateSubtotal($this->data['items']);
        $tax = HasTotalsArea::calculateTax($this->data['items']);
        $total = HasTotalsArea::calculateTotal($this->data['items']);
        
        $data['type'] = DocumentType::Estimate;
        $data['folio'] = static::getModel()::getNextFolio(DocumentType::Estimate);
        $data['date'] = now();
        $data['status'] = DocumentStatus::Placed;
        $data['user_id'] = auth()->id();
        $data['uuid'] = Str::uuid();
        
        $data['subtotal'] = $subtotal;
        $data['tax'] = $tax;
        $data['total'] = $total;

        return $data;
    }
}
