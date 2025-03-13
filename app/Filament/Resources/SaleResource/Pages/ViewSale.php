<?php

namespace App\Filament\Resources\SaleResource\Pages;

use Filament\Actions;
use App\Filament\Resources\SaleResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\IconPosition;
use App\Filament\Components\Actions\BackButton;

class ViewSale extends ViewRecord
{
    protected static string $resource = SaleResource::class;

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
            ])
            ->label('Más opciones')
            ->icon('heroicon-o-ellipsis-horizontal-circle')
            ->iconPosition(IconPosition::After)
            ->color('gray')
            ->button(),
        ];
    }
}
