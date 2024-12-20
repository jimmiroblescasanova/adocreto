<?php
namespace App\Filament\Components\Actions;

use Filament\Actions\Action;

class BackButton extends Action 
{   
    public static function getDefaultName(): ?string
    {
        return 'go-back';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
        ->label('Regresar')
        ->color('gray')
        ->url(fn ($record, $livewire): string => $this->determineBackUrl($record, $livewire));
    }

    protected function determineBackUrl($record, $livewire)
    {
        $resource = $livewire->getResource();
        
        $specificPages = [
            $resource::getUrl('create'), 
            $resource::getUrl('view', ['record' => $record]), 
            $resource::getUrl('edit', ['record' => $record])
        ];
        // Check if there's a referrer URL
        $referrer = request()->headers->get('referer');
        if ($referrer && !in_array($referrer, $specificPages)) {
            return $referrer;
        }

        // Otherwise, return the resource URL
        return $resource::getUrl();
    }
}
