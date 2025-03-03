<?php

namespace App\Filament\Resources\EstimateResource\Infolists;

use Filament\Infolists;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\FontWeight;

class EstimateInfolist extends Infolist
{
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            Infolists\Components\Group::make([
                Infolists\Components\Section::make('Datos generales')
                ->schema([
                    Infolists\Components\TextEntry::make('folio')
                    ->label('Folio')
                    ->inlineLabel()
                    ->alignEnd(),

                    Infolists\Components\TextEntry::make('date')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->inlineLabel()
                    ->alignEnd(),

                    Infolists\Components\TextEntry::make('entity.name')
                    ->label('Cliente')
                    ->columnSpanFull(),

                    Infolists\Components\TextEntry::make('title')
                    ->label('Título')
                    ->columnSpanFull(),
                ])
                ->columns()
                ->columnSpan(2),

                
                Infolists\Components\Section::make('Datos adicionales')
                ->schema([
                    Infolists\Components\TextEntry::make('status')
                    ->label('Estatus')
                    ->badge(),

                    Infolists\Components\TextEntry::make('user.name')
                    ->label('Vendedor')
                    ->badge(),
                ])
                ->columnSpan(1),
            ])
            ->columns(3)
            ->columnSpanFull(),

            Infolists\Components\Group::make([
                Infolists\Components\Section::make('Productos')
                ->schema([
                    Infolists\Components\RepeatableEntry::make('items')
                    ->hiddenLabel()
                    ->schema([
                        Infolists\Components\TextEntry::make('product.name')
                        ->label('Descripción')
                        ->columnSpan(2),

                        Infolists\Components\TextEntry::make('quantity')
                        ->label('Cantidad'),
                        
                        Infolists\Components\TextEntry::make('price')
                        ->label('Precio')
                        ->money('MXN'),

                        Infolists\Components\TextEntry::make('subtotal')
                        ->label('Subtotal')
                        ->money('MXN'),
                        
                        Infolists\Components\TextEntry::make('tax')
                        ->label('IVA')
                        ->money('MXN'),
                        
                        Infolists\Components\TextEntry::make('total')
                        ->label('Total')
                        ->money('MXN'),
                    ])
                    ->columns(7),
                ]),

                Infolists\Components\Fieldset::make('Total general')
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
            ])
            ->columnSpanFull(),
        ]);
    }
}