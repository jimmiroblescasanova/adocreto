<?php

namespace App\Filament\Resources\ProductionResource\Pages;

use Filament\Actions;
use App\Enums\ProductionStatus;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\ProductionResource;
use App\Filament\Components\Actions\BackButton;
use Illuminate\Support\Facades\Log;

class ViewProduction extends ViewRecord
{
    protected static string $resource = ProductionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),

            Actions\Action::make('startProduction')
            ->label('Iniciar producción')
            ->icon('heroicon-o-play')
            ->color('success')
            ->action(fn () => $this->startProduction())
            ->visible(fn () => $this->record->status === ProductionStatus::Pending),

            BackButton::make(),
        ];
    }

    private function startProduction(): void
    {
        //
    }
}
