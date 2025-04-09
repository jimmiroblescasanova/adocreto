<?php

namespace App\Filament\Resources\EstimateResource\Pages;

use App\Filament\Components\Actions\BackButton;
use App\Filament\Resources\EstimateResource;
use App\Mail\SendEstimateToClient;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\IconPosition;
use Illuminate\Support\Facades\Mail;

class ViewEstimate extends ViewRecord
{
    protected static string $resource = EstimateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),

            BackButton::make(),

            Actions\ActionGroup::make([
                Actions\Action::make('print')
                    ->label('Imprimir')
                    ->icon('heroicon-o-printer')
                    ->url(static::getResource()::getUrl('print', ['record' => $this->record])),

                Actions\Action::make('sendEmail')
                    ->label('Enviar por email')
                    ->icon('heroicon-o-envelope')
                    ->fillForm(function (): array {
                        return [
                            'emails' => [
                                $this->record->entity->email,
                            ],
                        ];
                    })
                    ->form([
                        Forms\Components\Repeater::make('emails')
                            ->simple(
                                Forms\Components\TextInput::make('email')
                                    ->label('Email')
                                    ->placeholder('Email')
                                    ->required()
                                    ->email(),
                            ),
                    ])
                    ->action(fn (array $data) => self::selectedEmails($data)),
            ])
                ->label('Más opciones')
                ->icon('heroicon-o-ellipsis-horizontal-circle')
                ->iconPosition(IconPosition::After)
                ->color('gray')
                ->button(),
        ];
    }

    public function selectedEmails($data): void
    {
        $emails = $data['emails'];

        foreach ($emails as $recipient) {
            try {
                Mail::to($recipient)->send(new SendEstimateToClient($this->record));
            } catch (\Exception $e) {
                Notification::make()
                    ->title('Error')
                    ->body('Ocurrió un error al enviar el email')
                    ->danger()
                    ->send();
            }
        }

        Notification::make()
            ->title('Emails enviados')
            ->body('El email ha sido enviado correctamente a todos los destinatarios')
            ->success()
            ->send();
    }
}
