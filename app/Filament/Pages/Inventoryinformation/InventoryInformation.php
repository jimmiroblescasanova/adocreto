<?php

namespace App\Filament\Pages\Inventoryinformation;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Pages\Page;
use App\Models\Warehouse;
use Filament\Tables\Table;
use App\Enums\DocumentType;
use App\Models\DocumentItem;
use Filament\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\Summarizers\Sum;
use App\Filament\Resources\InventoryInResource;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Filament\Resources\InventoryOutResource;
use Filament\Tables\Concerns\InteractsWithTable;
use App\Filament\Pages\Inventoryinformation\Widgets\InventoryInformationStats;

class InventoryInformation extends Page implements HasTable, HasForms
{   
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.modules.inventory-information';

    protected static ?string $navigationGroup = 'Reportes';

    protected static ?string $title = 'Información de inventario';

    public $defaultAction = 'showParameters';

    public ?array $data = [];

    public function table(Table $table): Table
    {
        if (isset($this->data['product_id']) ) {
            $query = DocumentItem::with('document')
                ->join('documents', 'document_items.document_id', '=', 'documents.id')
                ->select('document_items.*')
                ->selectRaw('(quantity * operation) / 100 as inventory')
                ->where('document_items.product_id', $this->data['product_id'])
                ->where('document_items.warehouse_id', $this->data['warehouse_id']);
        } else {
            $query = DocumentItem::query()->whereNull('id');
        }

        return $table
            ->query($query)
            ->defaultSort('documents.date', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('document.type')
                ->label('Tipo'),

                Tables\Columns\TextColumn::make('document.date')
                ->label('Fecha')
                ->date(),

                Tables\Columns\TextColumn::make('document.folio')
                ->label('Folio')
                ->alignCenter(),

                Tables\Columns\TextColumn::make('inventory')
                ->label('Cantidad')
                ->numeric()
                ->summarize(
                    Sum::make()
                    ->label('Total'),
                )
                ->alignEnd(),
            ])
            ->actions([
                Tables\Actions\Action::make('showDocument')
                ->label('Ver')
                ->url(function (DocumentItem $record): string {
                    return match ($record->document->type) {
                        DocumentType::InventoryIn => InventoryInResource::getUrl('view', ['record' => $record->document]),
                        DocumentType::InventoryOut => InventoryOutResource::getUrl('view', ['record' => $record->document]),
                    };
                }),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            $this->showParameters(),
        ];
    }

    public function showParameters(): Action
    {
        return Action::make('form')
        ->label('Mostrar parámetros')
        ->form([
            Forms\Components\Select::make('product_id')
            ->label('Selccionar producto')
            ->options(Product::pluck('name', 'id')) // TODO: Exclude services
            ->searchable()
            ->native(false)
            ->required(), 

            Forms\Components\Select::make('warehouse_id')
            ->label('Seleccionar almacén')
            ->options(Warehouse::getGroupedOptions())
            ->searchable()
            ->native(false)
            ->required(),
        ])
        ->action(function ($data) {
            $this->data = $data;
            $this->dispatch('inventory-parameters-updated', data: $data);
        });
    }

    protected function getHeaderWidgets(): array
    {
        return [
            InventoryInformationStats::class
        ];
    }
}
