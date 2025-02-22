<?php

namespace App\Filament\Resources\TransferResource\Pages;

use Filament\Actions;
use App\Enums\TransferStatus;
use Filament\Facades\Filament;
use App\Events\TransferInRoute;
use App\Events\TransferHasArrived;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\TransferResource;
use App\Filament\Components\Actions\BackButton;

class ViewTransfer extends ViewRecord
{
    protected static string $resource = TransferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),

            Actions\Action::make('send_to_route')
            ->label('Enviar a ruta')
            ->action(fn () => $this->sendTransferToRoute())
            ->icon('heroicon-m-truck')
            ->requiresConfirmation()
            ->visible(fn () => $this->record->status === TransferStatus::Pending),

            Actions\Action::make('mark_as_received')
            ->label('Marcar como recibido')
            ->action(fn () => $this->markAsReceived())
            ->icon('heroicon-m-check')
            ->requiresConfirmation()
            ->visible(fn () => $this->record->status === TransferStatus::InRoute),

            BackButton::make(),
        ];
    }

    private function sendTransferToRoute(): void
    {
        try {
            TransferInRoute::dispatch($this->record);

            $this->record->status = TransferStatus::InRoute;
            $this->record->save();

            Notification::make()
            ->title('Traspaso enviado a ruta')
            ->success()
            ->send();
        } catch (\Throwable $th) {
            Notification::make()
            ->title('Error al enviar el traspaso a ruta')
            ->body($th->getMessage())
            ->danger()
            ->send();
        }

        $this->redirect($this->getResource()::getUrl('index'));
    }

    private function markAsReceived(): void
    {
        try {
            TransferHasArrived::dispatch($this->record);

            $this->record->update([
                'status' => TransferStatus::Delivered,
                'accepted_by' => auth()->id(),
            ]);

            Notification::make()
            ->title('Traspaso marcado como recibido')
            ->success()
            ->send();
        } catch (\Throwable $th) {
            Notification::make()
            ->title('Error al marcar el traspaso como recibido')
            ->body($th->getMessage())
            ->danger()
            ->send();
        }

        $this->redirect($this->getResource()::getUrl('index'));
    }
}
