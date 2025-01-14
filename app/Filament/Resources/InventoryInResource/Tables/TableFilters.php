<?php 

namespace App\Filament\Resources\InventoryInResource\Tables;

use App\Enums\DocumentStatus;
use Illuminate\Support\Carbon;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class TableFilters 
{
    public static function documentFilters(): array
    {
        return [
            SelectFilter::make('status')
            ->label('Estado')
            ->options(DocumentStatus::class),

            SelectFilter::make('warehouse_id')
            ->label('Almacén')
            ->multiple()
            ->relationship(name: 'warehouse', titleAttribute: 'name')
            ->searchable()
            ->preload()
            ->optionsLimit(5),

            SelectFilter::make('entity_id')
            ->label('Proveedor')
            ->multiple()
            ->relationship(name: 'entity', titleAttribute: 'name')
            ->searchable()
            ->preload()
            ->optionsLimit(10)
            ->columnSpan(2),

            Filter::make('date')
            ->form([
                DatePicker::make('created_from')
                ->label('Desde'),
                DatePicker::make('created_until')
                ->label('Hasta'),
            ])
            ->indicateUsing(function (array $data): ?string {
                if (! $data['created_from']) {
                    return null;
                }

                return 'Del '
                . Carbon::parse($data['created_from'])->isoFormat('D [de] MMMM [de] YYYY')
                . ' al '
                . Carbon::parse($data['created_until'])->isoFormat('D [de] MMMM [de] YYYY');
            })
            ->query(function (Builder $query, array $data): Builder {
                return $query
                ->when(
                    $data['created_from'],
                    fn(Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                )
                ->when(
                    $data['created_until'],
                    fn(Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                );
            })->columns()
            ->columnSpan(2),
        ];
    }
}
