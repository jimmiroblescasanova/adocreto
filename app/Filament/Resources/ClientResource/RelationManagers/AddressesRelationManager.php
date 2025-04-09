<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    protected static ?string $modelLabel = 'dirección';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label('Tipo de dirección')
                    ->options([
                        1 => 'Facturación',
                        2 => 'Envío',
                    ])
                    ->required()
                    ->disabledOn('edit'),

                Forms\Components\TextInput::make('street')
                    ->label('Calle')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),

                Forms\Components\TextInput::make('exterior')
                    ->label('Exterior')
                    ->maxLength(255),

                Forms\Components\TextInput::make('interior')
                    ->label('Interior')
                    ->maxLength(255),

                Forms\Components\TextInput::make('neighborhood')
                    ->label('Colonia')
                    ->maxLength(255),

                Forms\Components\TextInput::make('zip')
                    ->label('Código postal')
                    ->maxLength(5)
                    ->required(),

                Forms\Components\TextInput::make('city')
                    ->label('Ciudad')
                    ->maxLength(255)
                    ->required(),

                Forms\Components\TextInput::make('state')
                    ->label('Estado')
                    ->maxLength(255)
                    ->required(),

                Forms\Components\TextInput::make('country')
                    ->label('País')
                    ->maxLength(255)
                    ->required(),

                Forms\Components\Textarea::make('notes')
                    ->label('Referencia')
                    ->columnSpanFull(),
            ])
            ->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Direcciones')
            ->recordTitleAttribute('street')
            ->defaultSort('type', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->formatStateUsing(function (string $state) {
                        return match ($state) {
                            '1' => 'Facturación',
                            '2' => 'Envío',
                        };
                    }),

                Tables\Columns\TextColumn::make('street')
                    ->label('Calle'),

                Tables\Columns\TextColumn::make('zip')
                    ->label('Código Postal'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->slideOver()
                    ->before(function (Tables\Actions\CreateAction $action, array $data) {
                        if ($this->getOwnerRecord()->hasBillingAddress() && $data['type'] == 1) {
                            Notification::make()
                                ->title('No se puede agregar la dirección')
                                ->body('El cliente ya tiene una dirección de facturación registrada.')
                                ->danger()
                                ->send();

                            $action->halt();
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver(),
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
