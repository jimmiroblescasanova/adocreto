<?php

namespace App\Filament\Resources;

use Filament\Forms\Form;
use App\Models\Production;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductionResource\Pages;
use App\Filament\Resources\ProductionResource as ExtraResource;
use App\Filament\Resources\ProductionResource\RelationManagers;

class ProductionResource extends Resource
{
    protected static bool $isScopedToTenant = false;

    protected static ?string $model = Production::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Documentos';

    protected static ?string $modelLabel = 'producción';
    protected static ?string $pluralModelLabel = 'producciones';

    public static function form(Form $form): Form
    {
        return ExtraResource\Forms\ProductionForm::form($form);
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
        ];
    }
}
