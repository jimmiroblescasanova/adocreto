<?php

namespace App\Livewire\Sales;

use App\Enums\ProductType;
use App\Models\Product;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class Estimate extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Product::query()->where('type', '!=', ProductType::Material))
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Producto')
                    ->searchable(),

                Tables\Columns\TextColumn::make('unit.name'),
            ])
            ->actions([
                Action::make('addProduct')
                    ->label('Agregar')
                    ->dispatch('selectProduct', fn (Product $record) => ['productId' => $record->id]),
            ]);
    }

    public function render()
    {
        return view('livewire.sales.estimate');
    }
}
