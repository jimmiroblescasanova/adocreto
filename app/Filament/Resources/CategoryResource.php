<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationGroup = 'Configuración';

    protected static ?string $modelLabel = 'categoría';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->minLength(3)
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->required(),

                Forms\Components\ColorPicker::make('color')
                    ->label('Color')
                    ->hex()
                    ->default('#000000')
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->label('Descripción')
                    ->columnSpanFull(),
            ]);
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

                Tables\Columns\ColorColumn::make('color')
                    ->label('Color')
                    ->sortable(),

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
                        $data['name'] = Str::title($data['name']);

                        return $data;
                    }),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCategories::route('/'),
        ];
    }
}
