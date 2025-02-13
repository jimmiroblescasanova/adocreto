<?php

namespace App\Filament\Resources\InventoryInResource\Pages;

use Filament\Actions;
use App\Enums\DocumentType;
use Illuminate\Support\Str;
use App\Enums\DocumentStatus;
use App\Traits\CreateActionsOnTop;
use App\Traits\RedirectsAfterSave;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\InventoryInResource;

class CreateInventoryIn extends CreateRecord
{
    use CreateActionsOnTop, RedirectsAfterSave;
    
    protected static string $resource = InventoryInResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = DocumentType::InventoryIn;
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
