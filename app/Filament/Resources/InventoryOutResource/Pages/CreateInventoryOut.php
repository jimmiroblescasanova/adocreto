<?php

namespace App\Filament\Resources\InventoryOutResource\Pages;

use App\Enums\DocumentStatus;
use App\Enums\DocumentType;
use App\Filament\Resources\InventoryOutResource;
use App\Traits\CreateActionsOnTop;
use App\Traits\RedirectsAfterSave;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreateInventoryOut extends CreateRecord
{
    use CreateActionsOnTop, RedirectsAfterSave;

    protected static string $resource = InventoryOutResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = DocumentType::InventoryOut;
        $data['status'] = DocumentStatus::Incomplete;
        $data['user_id'] = Auth::id();
        $data['uuid'] = Str::uuid();

        return $data;
    }

    protected function afterCreate(): void
    {
        try {
            $this->getRecord()->update([
                'subtotal' => $this->getRecord()->items->sum('subtotal'),
                'tax' => $this->getRecord()->items->sum('tax'),
                'total' => $this->getRecord()->items->sum('total'),
                'status' => DocumentStatus::Placed,
            ]);
        } catch (\Exception $th) {
            Notification::make()
                ->title('Error')
                ->body($th->getMessage())
                ->danger()
                ->actions([
                    Actions\Action::make('report')
                        ->label('Reportar error')
                        ->link(),
                ])
                ->send();
        }
    }
}
