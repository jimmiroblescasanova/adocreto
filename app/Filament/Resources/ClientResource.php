<?php

namespace App\Filament\Resources;

use App\Models\Entity;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ClientResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ClientResource\Forms\ClientForm;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Filament\Resources\ClientResource\Tables\ClientTable;

class ClientResource extends Resource
{
    protected static ?string $model = Entity::class;

    protected static ?string $modelLabel = 'cliente';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return ClientForm::form($form);
    }

    public static function table(Table $table): Table
    {
        return ClientTable::table($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AddressesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'view' => Pages\ViewClient::route('/{record}'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->clients();
    }
}
