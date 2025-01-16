<?php

namespace App\Filament\Resources\InventoryOutResource\Pages;

use Filament\Actions;
use App\Enums\DocumentType;
use Illuminate\Support\Str;
use App\Enums\DocumentStatus;
use App\Traits\CreateActionsOnTop;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\InventoryOutResource;

class CreateInventoryOut extends CreateRecord
{
    use CreateActionsOnTop;
    
    protected static string $resource = InventoryOutResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = DocumentType::InventoryOut;
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
                'status' => DocumentStatus::PLACED,
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
