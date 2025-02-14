<?php

namespace App\Filament\Resources\InventoryInResource\Infolists;

use Filament\Infolists;
use Filament\Infolists\Infolist;

class InventoryInInfolist extends Infolist 
{
    public static function infolist($infolist): Infolist
    {
        return $infolist
        ->schema([
            Infolists\Components\Group::make([
                Infolists\Components\Section::make('General')
                ->icon('heroicon-o-chevron-double-down')
                ->schema([
                    Infolists\Components\TextEntry::make('folio')
                    ->label('Folio')
                    ->inlineLabel()
                    ->alignEnd(),

                    Infolists\Components\TextEntry::make('date')
                    ->label('Fecha')
                    ->date()
                    ->inlineLabel()
                    ->alignEnd(),

                    Infolists\Components\TextEntry::make('order_number')
                    ->label('Número de orden'),

                    Infolists\Components\TextEntry::make('title')
                    ->label('Título')
                    ->columnSpan(2),

                    Infolists\Components\TextEntry::make('entity.name')
                    ->label('Proveedor'),

                    Infolists\Components\TextEntry::make('warehouse.name')
                    ->label('Almacén'),
                ])
                ->columns(),

                Infolists\Components\Section::make('Productos')
                ->icon('heroicon-o-truck')
                ->schema([
                    Infolists\Components\RepeatableEntry::make('items')
                    ->hiddenLabel()
                    ->contained(false)
                    ->schema([
                        Infolists\Components\TextEntry::make('product.name')
                        ->label('Producto')
                        ->columnSpan(2),

                        Infolists\Components\TextEntry::make('quantity')
                        ->label('Cantidad')
                        ->numeric(),

                        Infolists\Components\TextEntry::make('price')
                        ->label('Precio')
                        ->money('MXN'),

                        Infolists\Components\TextEntry::make('tax')
                        ->label('Impuesto')
                        ->money('MXN'),

                        Infolists\Components\TextEntry::make('total')
                        ->label('Total')
                        ->money('MXN'),
                    ])
                    ->columns(6)
                ]),

                Infolists\Components\Fieldset::make('Totales')
                ->schema([
                    Infolists\Components\TextEntry::make('subtotal')
                    ->label('Subtotal')
                    ->inlineLabel()
                    ->money('MXN')
                    ->alignEnd(),

                    Infolists\Components\TextEntry::make('tax')
                    ->label('Impuestos')
                    ->inlineLabel()
                    ->money('MXN')
                    ->alignEnd(),

                    Infolists\Components\TextEntry::make('total')
                    ->label('TOTAL')
                    ->inlineLabel()
                    ->money('MXN')
                    ->alignEnd(),
                ])
                ->columns(3),
            ])
            ->columnSpan(2),

            Infolists\Components\Group::make([
                Infolists\Components\Section::make('Adicional')
                ->icon('heroicon-o-information-circle')
                ->schema([
                    Infolists\Components\TextEntry::make('status')
                    ->label('Estado')
                    ->badge(),

                    Infolists\Components\TextEntry::make('user.name')
                    ->label('Creado por'),
                ]),
            ])
        ])
        ->columns(3);
    }
}
