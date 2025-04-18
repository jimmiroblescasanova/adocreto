<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource as ExtraResource;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Catalogos';

    protected static ?string $modelLabel = 'producto';

    public static function form(Form $form): Form
    {
        return ExtraResource\Forms\ProductForm::form($form);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return ExtraResource\Infolists\ProductInfolist::infolist($infolist);
    }

    public static function table(Table $table): Table
    {
        return ExtraResource\Tables\ProductTable::table($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PriceListsRelationManager::class,
            RelationManagers\ComponentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->products();
    }
}
