<?php

namespace App\Filament\Resources\InventoryInResource\Pages;

use App\Enums\DocumentStatus;
use App\Enums\DocumentType;
use App\Filament\Resources\InventoryInResource;
use App\Traits\CreateActionsOnTop;
use App\Traits\HasTotalsArea;
use App\Traits\RedirectsAfterSave;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreateInventoryIn extends CreateRecord
{
    use CreateActionsOnTop, RedirectsAfterSave;
    use HasTotalsArea;

    protected static string $resource = InventoryInResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = DocumentType::InventoryIn;
        $data['status'] = DocumentStatus::Placed;
        $data['user_id'] = Auth::id();
        $data['uuid'] = Str::uuid();

        $data['subtotal'] = $this->calculateSubtotal($this->data['items']);
        $data['tax'] = $this->calculateTax($this->data['items']);
        $data['total'] = $this->calculateTotal($this->data['items']);

        return $data;
    }
}
