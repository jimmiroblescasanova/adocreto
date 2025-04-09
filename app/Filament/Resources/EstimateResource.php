<?php

namespace App\Filament\Resources;

use App\Enums\DocumentType;
use App\Filament\Resources\EstimateResource as ExtraResource;
use App\Filament\Resources\EstimateResource\Pages;
use App\Models\Document;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EstimateResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Ventas';

    protected static ?string $modelLabel = 'cotización';

    protected static ?string $pluralModelLabel = 'cotizaciones';

    public static function form(Form $form): Form
    {
        return ExtraResource\Forms\EstimateForm::form($form);
    }

    public static function table(Table $table): Table
    {
        return ExtraResource\Tables\EstimateTable::table($table);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return ExtraResource\Infolists\EstimateInfolist::infolist($infolist);
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
            'index' => Pages\ListEstimates::route('/'),
            'create' => Pages\CreateEstimate::route('/create'),
            'view' => Pages\ViewEstimate::route('/{record}'),
            'edit' => Pages\EditEstimate::route('/{record}/edit'),
            'print' => Pages\PrintEstimate::route('/{record}/print'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', DocumentType::Estimate);
    }
}
