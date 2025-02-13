<?php 

namespace App\Filament\Resources\ProductResource\Infolists;

use App\Models\Product;
use Filament\Infolists;
use App\Enums\ProductType;
use Filament\Infolists\Infolist;
use CodeWithDennis\SimpleAlert\Components\Infolists\SimpleAlert;

class ProductInfolist extends Infolist
{
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            SimpleAlert::make('Información básica')
            ->title('Falta información')
            ->description('Por favor, captura la información de los componentes del producto.')
            ->warning()
            ->icon('heroicon-o-information-circle')
            ->border()
            ->columnSpanFull()
            ->hidden(function (Product $record): bool {
                $isFinalProduct = $record->type === ProductType::FinishedProduct;

                return $isFinalProduct ? $record->hasComponents() : true;
            }),
            
            Infolists\Components\Group::make([
                Infolists\Components\Section::make('Información básica')
                ->icon('heroicon-o-circle-stack')
                ->schema([
                    Infolists\Components\TextEntry::make('type')
                    ->label('Tipo'),

                    Infolists\Components\TextEntry::make('code')
                    ->label('Código'),

                    Infolists\Components\TextEntry::make('name')
                    ->label('Nombre')
                    ->columnSpanFull(),

                    Infolists\Components\TextEntry::make('description')
                    ->label('Descripción completa')
                    ->columnSpanFull(),

                    Infolists\Components\TextEntry::make('unit.name')
                    ->label('Unidad de venta'),
                    
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
                ]),

                Infolists\Components\Section::make('Producción')
                ->icon('heroicon-o-cog-6-tooth')
                ->schema([
                    Infolists\Components\TextEntry::make('production_conversion_quantity')
                    ->label('Cantidad de producción'),
                    
                    Infolists\Components\TextEntry::make('production_unit.name')
                    ->label('Unidad de producción'),
                ])
                ->hidden(fn (Product $record): bool => $record->production_unit_id === null),
            ])
        ])
        ->columns(3);
    }
}