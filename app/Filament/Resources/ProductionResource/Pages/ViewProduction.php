<?php

namespace App\Filament\Resources\ProductionResource\Pages;

use Filament\Actions;
use App\Enums\ProductionStatus;
use App\Events\ProductionStarted;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\ProductionResource;
use App\Filament\Components\Actions\BackButton;
use Filament\Notifications\Notification;
use App\Services\ProductionAvailabilityService;

class ViewProduction extends ViewRecord
{
    protected static string $resource = ProductionResource::class;

    protected function getHeaderActions(): array
    {
        $productionService = new ProductionAvailabilityService();
        $canBeProduced = $productionService->canBeProduced($this->record);

        return [
            Actions\EditAction::make(),

            Actions\Action::make('startProduction')
            ->label('Iniciar producción')
            ->icon('heroicon-o-play')
            ->color('success')
            ->action(fn () => $this->startProduction())
            ->visible(fn () => ($this->record->status === ProductionStatus::Pending) && $canBeProduced),

            BackButton::make(),
        ];
    }

    private function startProduction(): void
    {
        $this->record->status = ProductionStatus::InProgress;
        $this->record->started_at = now();
        $this->record->started_by = auth()->user()->id;
        $this->record->save();

        ProductionStarted::dispatch($this->record);

        Notification::make()
        ->title('Producción iniciada')
        ->success()
        ->send();

        $this->redirect($this->getResource()::getUrl('index'));
    }
}
