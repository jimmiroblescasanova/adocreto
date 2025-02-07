<?php

namespace App\Filament\Resources;

use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource as ExtraResource;

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
