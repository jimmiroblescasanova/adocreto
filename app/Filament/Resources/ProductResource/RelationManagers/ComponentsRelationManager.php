<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Enums\ProductType;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ComponentsRelationManager extends RelationManager
{
    protected static string $relationship = 'components';

    protected static ?string $title = 'Componentes';

    protected static ?string $modelLabel = 'material';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('component_id')
            ->label('Materia Prima')
            ->relationship(
                name: 'component', 
                titleAttribute: 'name', 
                modifyQueryUsing: function (Builder $query) {
                    return $query->where('type', ProductType::MATERIAL);
                }
            )
            ->searchable()
            ->preload()
            ->optionsLimit(15)
            ->required()
            ->live()
            ->columnSpan(2),

            Forms\Components\Placeholder::make('unit')
            ->label('Unidad')
            ->content(function (Get $get) {
                return Product::with('unit')->find($get('component_id'))->unit->name ?? '';
            }),

            Forms\Components\TextInput::make('quantity')
            ->label('Cantidad')
            ->numeric()
            ->inputMode('decimal')
            ->required(),
        ])
        ->columns(4);
    }

    public function table(Table $table): Table
    {
        return $table
        ->recordTitleAttribute('name')
        ->deferLoading()
        ->columns([
            Tables\Columns\TextColumn::make('component.code')
            ->label('Código'),

            Tables\Columns\TextColumn::make('component.name')
            ->label('Nombre del material'),

            Tables\Columns\TextColumn::make('quantity')
            ->label('Cantidad')
            ->numeric(decimalPlaces: 2)
            ->alignEnd(),

            Tables\Columns\TextColumn::make('product.unit.abbreviation')
            ->label('Unidad')
            ->alignEnd(),
        ])
        ->headerActions([
            Tables\Actions\CreateAction::make()
            ->label('Agregar material')
            ->before(function (Tables\Actions\CreateAction $action, array $data) {
                $recordExists = $this->getOwnerRecord()->components->contains('component_id', $data['component_id']);
                if ($recordExists) {
                    Notification::make()
                    ->title('No se puede agregar')
                    ->body('El material ya es parte de los componentes')
                    ->warning()
                    ->send();

                    $action->cancel();
                }
            }),
        ])
        ->actions([
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
