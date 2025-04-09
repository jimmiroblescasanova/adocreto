<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Enums\DocumentStatus;
use App\Enums\DocumentType;
use App\Filament\Resources\SaleResource;
use App\Models\Address;
use App\Traits\CreateActionsOnTop;
use App\Traits\HasTotalsArea;
use App\Traits\ManageProductsFromModal;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateSale extends CreateRecord
{
    use CreateActionsOnTop;
    use HasTotalsArea;
    use ManageProductsFromModal;

    protected static string $resource = SaleResource::class;

    public int $addressId;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $subtotal = HasTotalsArea::calculateSubtotal($this->data['items']);
        $tax = HasTotalsArea::calculateTax($this->data['items']);
        $total = HasTotalsArea::calculateTotal($this->data['items']);

        $data['type'] = DocumentType::Sale;
        $data['folio'] = static::getModel()::getNextFolio(DocumentType::Sale);
        $data['date'] = now();
        $data['status'] = DocumentStatus::Placed;
        $data['user_id'] = auth()->id();
        $data['uuid'] = Str::uuid();

        $data['subtotal'] = $subtotal;
        $data['tax'] = $tax;
        $data['total'] = $total;

        $this->addressId = $data['address'] ?? 0;
        unset($data['address']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $address = Address::find($this->addressId);
        if ($address) {
            $duplicatedAddress = $address->replicate();
            unset($duplicatedAddress->address_line_1, $duplicatedAddress->address_line_2);
            $this->record->address()->save($duplicatedAddress);
        }
    }
}
