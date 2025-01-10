<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Document;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\DocumentTypeEnum;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\InventoryInResource\Pages;
use App\Filament\Resources\InventoryInResource as ExtraResource;
use App\Filament\Resources\InventoryInResource\RelationManagers;

class InventoryInResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Entrada de inventario';

    public static function form(Form $form): Form
    {
        return ExtraResource\Forms\InventoryInForm::form($form);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('date')
            ->label('Fecha')
            ->date(),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
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
        return parent::getEloquentQuery()->where('type', DocumentTypeEnum::InventoryIn);
    }
}
