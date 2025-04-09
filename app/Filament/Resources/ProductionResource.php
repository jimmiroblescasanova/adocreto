<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductionResource as ExtraResource;
use App\Filament\Resources\ProductionResource\Pages;
use App\Models\Production;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class ProductionResource extends Resource
{
    protected static ?string $model = Production::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Documentos';

    protected static ?string $modelLabel = 'producción';

    protected static ?string $pluralModelLabel = 'producciones';

    public static function form(Form $form): Form
    {
        return ExtraResource\Forms\ProductionForm::form($form);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return ExtraResource\Infolists\ProductionInfolist::infolist($infolist);
    }

    public static function table(Table $table): Table
    {
        return ExtraResource\Tables\ProductionTable::table($table);
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
            'index' => Pages\ListProductions::route('/'),
            'create' => Pages\CreateProduction::route('/create'),
            'view' => Pages\ViewProduction::route('/{record}'),
            'edit' => Pages\EditProduction::route('/{record}/edit'),
            'manage' => Pages\CompleteProduction::route('{record}/manage'),
        ];
    }
}
