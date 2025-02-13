<?php 

namespace App\Filament\Resources\MaterialResource\Infolists;

use Filament\Infolists;
use Filament\Infolists\Infolist;

class MaterialInfolist extends Infolist
{
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            Infolists\Components\Group::make([
                Infolists\Components\Section::make('Información básica')
                ->icon('heroicon-o-circle-stack')
                ->schema([
                    Infolists\Components\TextEntry::make('code')
                    ->label('Código'),

                    Infolists\Components\TextEntry::make('unit.name')
                    ->label('Unidad de medida'),

                    Infolists\Components\TextEntry::make('name')
                    ->label('Nombre')
                    ->columnSpanFull(),

                    Infolists\Components\TextEntry::make('description')
                    ->label('Descripción completa')
                    ->columnSpanFull(),
                ])
                ->columns(),
            ])
            ->columnSpan(2), 

            Infolists\Components\Group::make([
                Infolists\Components\Section::make('Información adicional')
                ->icon('heroicon-o-information-circle')
                ->schema([
                    Infolists\Components\TextEntry::make('active')
                    ->label('Estado')
                    ->badge(),

                    Infolists\Components\TextEntry::make('category.name')
                    ->label('Categoría'),

                    Infolists\Components\TextEntry::make('created_at')
                    ->label('Fecha de creación')
                    ->date(),

                    Infolists\Components\TextEntry::make('updated_at')
                    ->label('Últ. actualización')
                    ->since(),
                ])
            ]),
        ])
        ->columns(3);
    }
}