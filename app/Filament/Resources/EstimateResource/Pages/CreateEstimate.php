<?php

namespace App\Filament\Resources\EstimateResource\Pages;

use App\Enums\DocumentStatus;
use App\Enums\DocumentType;
use App\Filament\Resources\EstimateResource;
use App\Traits\CreateActionsOnTop;
use App\Traits\HasTotalsArea;
use App\Traits\ManageProductsFromModal;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateEstimate extends CreateRecord
{
    use CreateActionsOnTop;
    use HasTotalsArea;
    use ManageProductsFromModal;

    protected static string $resource = EstimateResource::class;

    public int $addressId;

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

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('print', ['record' => $this->record]);
    }
}
