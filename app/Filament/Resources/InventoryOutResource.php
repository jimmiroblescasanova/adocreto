<?php

namespace App\Filament\Resources;

use App\Models\Document;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\DocumentType;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\InventoryOutResource\Pages;
use App\Filament\Resources\InventoryOutResource as ExtraResource;
use App\Filament\Resources\InventoryOutResource\RelationManagers;

class InventoryOutResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Documentos';

    protected static ?string $modelLabel = 'Salida de inventario';

    protected static ?string $pluralModelLabel = 'Salidas de inventario';

    public static function form(Form $form): Form
    {
        return ExtraResource\Forms\InventoryOutForm::form($form);
    }

    public static function table(Table $table): Table
    {
        return ExtraResource\Tables\InventoryOutTable::table($table);
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
            'index' => Pages\ListInventoryOuts::route('/'),
            'create' => Pages\CreateInventoryOut::route('/create'),
            'view' => Pages\ViewInventoryOut::route('/{record}'),
            'edit' => Pages\EditInventoryOut::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', DocumentType::InventoryOut);
    }
}
