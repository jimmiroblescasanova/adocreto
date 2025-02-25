<?php

namespace App\Filament\Pages\Modules;

use Livewire\Attributes\On;
use App\Models\DocumentItem;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class InventoryInformationStats extends BaseWidget
{
    public $data = [];

    #[On('inventory-parameters-updated')]
    public function handleParametersUpdated($data)
    {
        $this->data = $data;
    }
    
    protected function getStats(): array
    {
        $query = DocumentItem::with('document')
            ->selectRaw('SUM((quantity * operation) / 100) as total_inventory')
            ->where('product_id', $this->data['product_id'] ?? 0)
            ->where('warehouse_id', $this->data['warehouse_id'] ?? 0)
            ->first();

        return [
            Stat::make('Total del inventario actual', number_format($query?->total_inventory ?? 0, 2, '.', ',')),
        ];
    }
}
