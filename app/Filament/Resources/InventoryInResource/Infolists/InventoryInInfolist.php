<?php

namespace App\Filament\Resources\InventoryInResource\Infolists;

use Filament\Infolists;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
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
                                ->label('Folio'),

                            Infolists\Components\TextEntry::make('date')
                                ->label('Fecha')
                                ->date(),

                            Infolists\Components\TextEntry::make('order_number')
                                ->label('Número de orden'),

                            Infolists\Components\TextEntry::make('entity.name')
                                ->label('Proveedor')
                                ->size(TextEntrySize::Large)
                                ->columnSpanFull(),

                            Infolists\Components\TextEntry::make('title')
                                ->label('Título')
                                ->columnSpanFull(),
                        ])
                        ->columns(3)
                        ->columnSpan(2),

                    Infolists\Components\Section::make('Adicional')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Infolists\Components\TextEntry::make('status')
                                ->label('Estado')
                                ->badge(),

                            Infolists\Components\TextEntry::make('user.name')
                                ->label('Creado por'),
                        ])
                        ->columnSpan(1),
                ])
                    ->columns(3)
                    ->columnSpanFull(),

                Infolists\Components\Group::make([
                    Infolists\Components\Section::make('Productos')
                        ->icon('heroicon-o-truck')
                        ->schema([
                            Infolists\Components\RepeatableEntry::make('items')
                                ->hiddenLabel()
                                ->schema([
                                    Infolists\Components\TextEntry::make('quantity')
                                        ->label('Cantidad')
                                        ->numeric(),

                                    Infolists\Components\TextEntry::make('product.name')
                                        ->label('Producto')
                                        ->columnSpan(2),

                                    Infolists\Components\TextEntry::make('warehouse.name')
                                        ->label('Almacén'),

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
                                ->columns(7),
                        ]),

                    Infolists\Components\Fieldset::make('Totales')
                        ->schema([
                            Infolists\Components\TextEntry::make('subtotal')
                                ->label('Subtotal')
                                ->inlineLabel()
                                ->money('MXN')
                                ->alignEnd()
                                ->size(TextEntrySize::Medium),

                            Infolists\Components\TextEntry::make('tax')
                                ->label('Impuestos')
                                ->inlineLabel()
                                ->money('MXN')
                                ->alignEnd()
                                ->size(TextEntrySize::Medium),

                            Infolists\Components\TextEntry::make('total')
                                ->label('TOTAL')
                                ->inlineLabel()
                                ->money('MXN')
                                ->alignEnd()
                                ->size(TextEntrySize::Large),
                        ])
                        ->columns(3),
                ])
                    ->columnSpanFull(),
            ]);
    }
}
