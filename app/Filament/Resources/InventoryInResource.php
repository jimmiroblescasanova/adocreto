<?php

namespace App\Filament\Resources;

use App\Enums\DocumentType;
use App\Filament\Resources\InventoryInResource as ExtraResource;
use App\Filament\Resources\InventoryInResource\Pages;
use App\Models\Document;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InventoryInResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Documentos';

    protected static ?string $modelLabel = 'entrada de inventario';

    public static function form(Form $form): Form
    {
        return ExtraResource\Forms\InventoryInForm::form($form);
    }

    public static function table(Table $table): Table
    {
        return ExtraResource\Tables\InventoryInTable::table($table);
    }

    public static function infolist($infolist): Infolist
    {
        return ExtraResource\Infolists\InventoryInInfolist::infolist($infolist);
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
            'index' => Pages\ListInventoryIns::route('/'),
            'create' => Pages\CreateInventoryIn::route('/create'),
            'view' => Pages\ViewInventoryIn::route('/{record}'),
            'edit' => Pages\EditInventoryIn::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', DocumentType::InventoryIn);
    }
}
