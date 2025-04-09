<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnitResource\Pages;
use App\Models\Unit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Configuración';

    protected static ?string $modelLabel = 'unidad';

    protected static ?string $pluralModelLabel = 'unidades';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->autocapitalize('words')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->columnSpan(2),

                Forms\Components\TextInput::make('abbreviation')
                    ->label('Abreviación')
                    ->maxLength(3)
                    ->unique(ignoreRecord: true)
                    ->required(),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort(column: 'name', direction: 'asc')
            ->striped()
            ->deferLoading()
            ->deferFilters()
            ->persistSearchInSession()
            ->persistFiltersInSession()
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->grow(),

                Tables\Columns\TextColumn::make('abbreviation')
                    ->label('Abreviación')
                    ->searchable()
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->date()
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Últ. actualización')
                    ->since()
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['name'] = strtoupper($data['name']);
                        $data['abbreviation'] = strtoupper($data['abbreviation']);

                        return $data;
                    }),

                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUnits::route('/'),
        ];
    }
}
