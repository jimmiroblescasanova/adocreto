<?php

namespace App\Filament\Resources\ClientResource\Infolists;

use Filament\Infolists;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;

class ClientInfolist extends Infolist
{
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Group::make([
                    Infolists\Components\Section::make('Datos generales')
                        ->icon('heroicon-o-user')
                        ->schema([
                            Infolists\Components\TextEntry::make('code')
                                ->label('Código'),

                            Infolists\Components\TextEntry::make('name')
                                ->label('Nombre')
                                ->size(TextEntrySize::Large)
                                ->columnSpanFull(),

                            Infolists\Components\TextEntry::make('rfc')
                                ->label('RFC'),

                            Infolists\Components\TextEntry::make('email')
                                ->label('Correo electrónico')
                                ->copyable(),

                            Infolists\Components\TextEntry::make('phone')
                                ->label('Teléfono')
                                ->copyable(),
                        ])
                        ->columns(),
                ])
                    ->columnSpan(2),

                Infolists\Components\Group::make([
                    Infolists\Components\Section::make('Fiscal')
                        ->icon('heroicon-o-qr-code')
                        ->schema([
                            Infolists\Components\TextEntry::make('regimenFiscal.descripcion')
                                ->label('Régimen Fiscal'),

                            Infolists\Components\TextEntry::make('usoCfdi.descripcion')
                                ->label('Uso CFDI'),
                        ]),

                    Infolists\Components\Section::make('Adicionales')
                        ->icon('heroicon-o-information-circle')
                        ->schema([Infolists\Components\TextEntry::make('active')
                            ->label('Estado')
                            ->badge(),

                            Infolists\Components\TextEntry::make('notes')
                                ->label('Notas'),

                            Infolists\Components\TextEntry::make('created_at')
                                ->label('Fecha de creación')
                                ->date(),

                            Infolists\Components\TextEntry::make('updated_at')
                                ->label('Últ. actualización')
                                ->since(),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
