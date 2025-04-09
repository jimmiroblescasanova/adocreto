<?php

namespace App\Filament\Resources\ProductionResource\Pages;

use App\Filament\Resources\ProductionResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class CompleteProduction extends Page implements HasForms, HasInfolists
{
    use InteractsWithForms;
    use InteractsWithInfolists;
    use InteractsWithRecord;

    protected static string $resource = ProductionResource::class;

    protected static string $view = 'filament.resources.production-resource.pages.complete-production';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->schema([
                Infolists\Components\TextEntry::make('warehouse.name'),

                Infolists\Components\RepeatableEntry::make('items')
                    ->schema([
                        Infolists\Components\TextEntry::make('product.name'),
                        Infolists\Components\TextEntry::make('quantity'),

                        Infolists\Components\TextEntry::make('available_quantity'),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('distribute')
                ->label('Distribuir producción')
                ->color('success')
                ->steps([
                    Forms\Components\Wizard\Step::make('warehouse')
                        ->description('Selecciona el depósito al que se distribuirá la producción')
                        ->schema([
                            Forms\Components\Select::make('warehouse_id')
                                ->relationship('warehouse', 'name')
                                ->required(),
                        ]),

                    Forms\Components\Wizard\Step::make('items')
                        ->description('Selecciona los productos que se distribuirán')
                        ->schema([
                            Forms\Components\Select::make('product_id')
                                ->options(function () {
                                    return $this->record->items->pluck('product.name', 'product.id');
                                })
                                ->required(),
                        ]),
                ]),
        ];
    }
}
