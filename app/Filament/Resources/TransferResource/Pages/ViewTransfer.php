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
            ->visible(fn () => $this->record->status === TransferStatus::InRoute),

            BackButton::make(),
        ];
    }

    private function sendTransferToRoute(): void
    {
        $tenant = Filament::getTenant();
        
        $this->record->status = TransferStatus::InRoute;
        $this->record->save();

        TransferInRoute::dispatch($this->record, $tenant);

        Notification::make()
        ->title('Traspaso enviado a ruta')
        ->success()
        ->send();

        $this->redirect($this->getResource()::getUrl('index'));
    }

    private function markAsReceived(): void
    {
        try {
            $tenant = Filament::getTenant();
            TransferHasArrived::dispatch($this->record, $tenant);

            $this->record->status = TransferStatus::Delivered;
            $this->record->save();

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
