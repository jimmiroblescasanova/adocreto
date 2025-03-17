<?php

namespace App\Filament\Resources\InventoryInResource\Pages;

use App\Enums\DocumentStatus;
use App\Enums\InventoryOperation;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Components\Actions\BackButton;
use App\Filament\Resources\InventoryInResource;
use Filament\Notifications\Notification;
use Filament\Support\Enums\IconPosition;

class ViewInventoryIn extends ViewRecord
{
    protected static string $resource = InventoryInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),

            BackButton::make(),

            Actions\ActionGroup::make([
                Actions\Action::make('cancel')
                ->label('Cancelar')
                ->icon('heroicon-o-x-circle')
                ->action(fn () => $this->cancelDocument())
                ->requiresConfirmation(),
            ])
            ->label('Acciones')
            ->icon('heroicon-o-ellipsis-horizontal-circle')
            ->iconPosition(IconPosition::After)
            ->button()
            ->color('gray'),
        ];
    }

    private function cancelDocument(): void
    {
        try {
            $this->record->items()->update([
                'operation' => InventoryOperation::NoEffect,
            ]);

            $this->record->update([
                'status' => DocumentStatus::Cancelled,
            ]);
        } catch (\Throwable $th) {
            Notification::make()
            ->title('Error al cancelar')
            ->body($th->getMessage())
            ->danger()
            ->send();
        }
    }
}
