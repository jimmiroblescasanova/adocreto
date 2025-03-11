<?php

namespace App\Filament\Resources\SaleResource\Pages;

use Filament\Actions;
use App\Models\Address;
use App\Enums\DocumentType;
use Illuminate\Support\Str;
use App\Enums\DocumentStatus;
use App\Traits\HasTotalsArea;
use App\Traits\CreateActionsOnTop;
use App\Traits\ManageProductsFromModal;
use App\Filament\Resources\SaleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSale extends CreateRecord
{
    use CreateActionsOnTop;
    use ManageProductsFromModal;
    use HasTotalsArea;

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

        $this->addressId = $data['address'];
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
