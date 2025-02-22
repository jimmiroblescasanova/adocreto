<?php

namespace App\Filament\Resources\ProductionResource\Infolists;

use Filament\Infolists;
use Filament\Infolists\Infolist;

class ProductionInfolist extends Infolist
{
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            Infolists\Components\Group::make([
                Infolists\Components\Section::make('Datos generales')
                ->icon('heroicon-o-queue-list')
                ->schema([
                    Infolists\Components\TextEntry::make('folio')
                    ->label('Folio'),

                    Infolists\Components\TextEntry::make('title')
                    ->label('Título'),

                    Infolists\Components\TextEntry::make('warehouse.name')
                    ->label('Almacén de Material Prima'),
                ])
                ->columns(),

                Infolists\Components\Section::make('Productos a fabricar')
                ->icon('heroicon-o-cog-6-tooth')
                ->schema([
                    Infolists\Components\RepeatableEntry::make('items')
                    ->hiddenLabel()
                    ->contained(false)
                    ->schema([
                        Infolists\Components\TextEntry::make('product.name')
                        ->label('Producto')
                        ->columnSpan(2),

                        Infolists\Components\TextEntry::make('quantity')
                        ->label('Cantidad'),

                        Infolists\Components\TextEntry::make('product.unit.abbreviation')
                        ->label('Unidad'),
                    ])
                    ->columns(4),
                ])
                ->collapsible(),

                Infolists\Components\Section::make('Materia prima requerida')
                ->icon('heroicon-o-cube-transparent')
                ->schema([
                    Infolists\Components\RepeatableEntry::make('components')
                    ->hiddenLabel()
                    ->contained(false)
                    ->schema([
                        Infolists\Components\TextEntry::make('product.name')
                        ->label('Producto')
                        ->columnSpan(2),

                        Infolists\Components\TextEntry::make('quantity')
                        ->label('Cantidad'),

                        Infolists\Components\TextEntry::make('product.unit.abbreviation')
                        ->label('Unidad'),
                    ])
                    ->columns(4),
                ])
                ->collapsed()
                ->collapsible(),
            ])
            ->columnSpan(2),

            Infolists\Components\Group::make([
                Infolists\Components\Section::make('Información de la producción')
                ->icon('heroicon-o-calendar-days')
                ->schema([
                    Infolists\Components\TextEntry::make('status')
                    ->label('Estado')
                    ->badge(),
                    
                    Infolists\Components\TextEntry::make('user.name')
                    ->label('Creado por'),

                    Infolists\Components\TextEntry::make('started_at')
                    ->label('Fecha de inicio')
                    ->dateTime(),

                    Infolists\Components\TextEntry::make('started_by')
                    ->label('Iniciado por'),

                    Infolists\Components\TextEntry::make('finished_at')
                    ->label('Fecha de finalización')
                    ->dateTime(),
                    
                    Infolists\Components\TextEntry::make('finished_by')
                    ->label('Finalizado por'),
                ])
            ])
        ])
        ->columns(3);
    }
}