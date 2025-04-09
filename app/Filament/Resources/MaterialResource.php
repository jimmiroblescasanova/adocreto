<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialResource as ExtraResource;
use App\Filament\Resources\MaterialResource\Pages;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MaterialResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Catalogos';

    protected static ?string $modelLabel = 'materia prima';

    protected static ?string $pluralModelLabel = 'materias primas';

    public static function form(Form $form): Form
    {
        return ExtraResource\Forms\MaterialForm::form($form);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return ExtraResource\Infolists\MaterialInfolist::infolist($infolist);
    }

    public static function table(Table $table): Table
    {
        return ExtraResource\Tables\MaterialTable::table($table);
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
            'index' => Pages\ListMaterials::route('/'),
            'create' => Pages\CreateMaterial::route('/create'),
            'view' => Pages\ViewMaterial::route('/{record}'),
            'edit' => Pages\EditMaterial::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->materials();
    }
}
