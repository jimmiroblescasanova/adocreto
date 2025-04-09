<?php

namespace App\Filament\Resources\ProductionResource\Pages;

use App\Enums\ProductionStatus;
use App\Events\ProductionStarted;
use App\Filament\Components\Actions\BackButton;
use App\Filament\Resources\ProductionResource;
use App\Services\ProductionAvailabilityService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewProduction extends ViewRecord
{
    protected static string $resource = ProductionResource::class;

    protected function getHeaderActions(): array
    {
        $productionService = new ProductionAvailabilityService;
        $canBeProduced = $productionService->canBeProduced($this->record);

        return [
            Actions\EditAction::make(),

            Actions\Action::make('startProduction')
                ->label('Iniciar producción')
                ->icon('heroicon-o-play')
                ->color('success')
                ->action(fn () => $this->startProduction())
                ->visible(fn () => ($this->record->status === ProductionStatus::Pending) && $canBeProduced),

            Actions\Action::make('finishProduction')
                ->label('Finalizar producción')
                ->icon('heroicon-o-check')
                ->color('success')
                ->action(fn () => $this->finishProduction())
                ->visible(fn () => ($this->record->status === ProductionStatus::InProgress)),

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

    // TODO: Implement finishProduction
    private function finishProduction(): void
    {
        $this->redirect($this->getResource()::getUrl('manage', ['record' => $this->record->id]));
    }
}
