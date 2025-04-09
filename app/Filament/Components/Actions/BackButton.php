<?php

namespace App\Filament\Components\Actions;

use Filament\Actions\Action;

class BackButton extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'backToIndex';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('Ver todos')
            ->color('gray')
            ->url(fn ($livewire): string => $livewire->getResource()::getUrl('index'));
    }
}
