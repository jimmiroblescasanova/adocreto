<?php

namespace App\Filament\Resources\SaleResource\Infolists;

use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\TextEntry\TextEntrySize;

class SaleInfolist extends Infolist 
{
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            Infolists\Components\Group::make([
                Infolists\Components\Section::make('Datos generales')
                ->icon('heroicon-o-building-storefront')
                ->schema([
                    Infolists\Components\TextEntry::make('date')
                    ->label('Fecha')
                    ->date('d/m/Y'),

                    Infolists\Components\TextEntry::make('folio')
                    ->label('Folio'),

                    Infolists\Components\TextEntry::make('entity.name')
                    ->label('Cliente'),

                    Infolists\Components\TextEntry::make('address.address_line_1')
                    ->label('Dirección'),
                ])
                ->columns()
                ->columnSpan(2),

                Infolists\Components\Section::make('Datos adicionales')
                ->schema([
                    Infolists\Components\TextEntry::make('status')
                    ->label('Estatus')
                    ->badge(),

                    Infolists\Components\TextEntry::make('user.name')
                    ->label('Usuario')
                    ->badge(),
                ])
                ->columnSpan(1),
            ])
            ->columns(3)
            ->columnSpanFull(),

            Infolists\Components\Group::make([
                Infolists\Components\Section::make('Productos')
                ->icon('heroicon-o-shopping-cart')
                ->schema([
                    Infolists\Components\RepeatableEntry::make('items')
                    ->hiddenLabel()
                    ->schema([
                        Infolists\Components\TextEntry::make('product.name')
                        ->label('Producto')
                        ->grow(),

                        Infolists\Components\TextEntry::make('quantity')
                        ->label('Cantidad')
                        ->numeric(decimalPlaces: 2),

                        Infolists\Components\TextEntry::make('price')
                        ->label('Precio')
                        ->money('MXN'),

                        Infolists\Components\TextEntry::make('tax')
                        ->label('IVA')
                        ->money('MXN'),

                        Infolists\Components\TextEntry::make('total')
                        ->label('Total')
                        ->money('MXN'),
                    ])
                    ->columns(5),
                ]),
            ])
            ->columnSpanFull(),

            Infolists\Components\Fieldset::make('Totales')
            ->schema([
                Infolists\Components\TextEntry::make('subtotal')
                ->label('Subtotal')
                ->money('MXN')
                ->size(TextEntrySize::Medium),

                Infolists\Components\TextEntry::make('tax')
                ->label('IVA')
                ->money('MXN')
                ->size(TextEntrySize::Medium),

                Infolists\Components\TextEntry::make('total')
                ->label('Total')
                ->money('MXN')
                ->weight(FontWeight::Bold)
                ->size(TextEntrySize::Large),
            ])
            ->columns(3),
        ]);
    }
}
