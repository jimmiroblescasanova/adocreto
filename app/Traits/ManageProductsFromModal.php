<?php

namespace App\Traits;

use App\Models\Price;
use App\Models\Product;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Filament\Notifications\Notification;

trait ManageProductsFromModal
{
    #[On('selectProduct')]
    public function addProduct(int $productId)
    {
        $currentProducts = data_get($this->data, 'items.*.product_id');

        if (in_array($productId, $currentProducts)) {
            Notification::make()
            ->title('Producto ya agregado')
            ->danger()
            ->send();
            
            return;
        }

        $uuid = Str::uuid();

        data_set($this->data, "items.{$uuid}.product_id", $productId);

        $product = Product::find($productId);
        $price = Price::whereBelongsTo($product)->first()->price ?? 0;

        data_set($this->data, "items.{$uuid}.price", $price);
        
        Notification::make()
        ->title('Producto agregado')
        ->success()
        ->send();
    }
}
