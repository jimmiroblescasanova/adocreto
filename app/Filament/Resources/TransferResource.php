<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransferResource as ExtraResource;
use App\Filament\Resources\TransferResource\Pages;
use App\Models\Transfer;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class TransferResource extends Resource
{
    protected static ?string $model = Transfer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Documentos';

    protected static ?string $modelLabel = 'traspaso';

    public static function form(Form $form): Form
    {
        return ExtraResource\Forms\TransferForm::form($form);
    }

    public static function table(Table $table): Table
    {
        return ExtraResource\Tables\TransferTable::table($table);
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
            'index' => Pages\ListTransfers::route('/'),
            'create' => Pages\CreateTransfer::route('/create'),
            'view' => Pages\ViewTransfer::route('/{record}'),
            'edit' => Pages\EditTransfer::route('/{record}/edit'),
        ];
    }
}
