<?php

namespace App\Traits;

use Filament\Actions;
use Filament\Support\Enums\IconPosition;

trait EditActionsOnTop
{
    protected function getHeaderActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->formId('form'),

            $this->getCancelFormAction(),

            Actions\ActionGroup::make([
                Actions\DeleteAction::make(),
            ])
                ->label('Más')
                ->icon('heroicon-o-ellipsis-horizontal-circle')
                ->iconPosition(IconPosition::After)
                ->color('gray')
                ->button(),
        ];
    }

    protected function getFormActions(): array
    {
        return [];
    }
}
