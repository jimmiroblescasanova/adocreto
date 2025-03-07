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
use App\Models\Address;

class CreateEstimate extends CreateRecord
{
    use ManageProductsFromModal;
    use CreateActionsOnTop;
    use HasTotalsArea;

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

        $this->addressId = $data['address'];
        unset($data['address']);

        return $data;
    }

    public function after(): void
    {
        $address = Address::find($this->addressId);
        if ($address) {
            $duplicatedAddress = $address->replicate();
            unset($duplicatedAddress->address_line_1, $duplicatedAddress->address_line_2);
            $this->record->address()->save($duplicatedAddress);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('print', ['record' => $this->record]);
    }
}
