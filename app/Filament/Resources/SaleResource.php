<?php

namespace App\Filament\Resources;

use App\Models\Document;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\DocumentType;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SaleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SaleResource as ExtraResource;
use App\Filament\Resources\SaleResource\RelationManagers;

class SaleResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Ventas';

    protected static ?string $modelLabel = 'venta';

    public static function form(Form $form): Form
    {
        return ExtraResource\Forms\SaleForm::form($form);
    }

    public static function table(Table $table): Table
    {
        return ExtraResource\Tables\SaleTable::table($table);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return ExtraResource\Infolists\SaleInfolist::infolist($infolist);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'view' => Pages\ViewSale::route('/{record}'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
            'print' => Pages\PrintSale::route('/{record}/print'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', DocumentType::Sale);
    }
}
