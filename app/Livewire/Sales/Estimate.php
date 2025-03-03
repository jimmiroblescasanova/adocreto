<?php

namespace App\Livewire\Sales;

use Filament\Tables;
use App\Models\Product;
use Livewire\Component;
use App\Enums\ProductType;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class Estimate extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
        ->query(Product::query()->where('type', '!=', ProductType::Material))
        ->columns([
            Tables\Columns\TextColumn::make('name')
            ->label('Producto')
            ->searchable(),

            Tables\Columns\TextColumn::make('unit.name'),
        ])
        ->actions([
            Action::make('addProduct')
            ->label('Agregar')
            ->dispatch('selectProduct', fn (Product $record) => ['productId' => $record->id])
        ]);
    }
    
    public function render()
    {
        return view('livewire.sales.estimate');
    }
}
