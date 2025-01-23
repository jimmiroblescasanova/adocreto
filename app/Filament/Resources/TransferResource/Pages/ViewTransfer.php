<?php

namespace App\Filament\Resources\TransferResource\Pages;

use Filament\Actions;
use App\Enums\TransferStatus;
use Filament\Facades\Filament;
use App\Events\TransferInRoute;
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
}
