<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource as ExtraResource;
use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Entity;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ClientResource extends Resource
{
    protected static ?string $model = Entity::class;

    protected static ?string $navigationGroup = 'Catalogos';

    protected static ?string $modelLabel = 'cliente';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return ExtraResource\Forms\ClientForm::form($form);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return ExtraResource\Infolists\ClientInfolist::infolist($infolist);
    }

    public static function table(Table $table): Table
    {
        return ExtraResource\Tables\ClientTable::table($table);
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
