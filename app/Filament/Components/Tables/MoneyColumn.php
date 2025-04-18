<?php

namespace App\Filament\Components\Tables;

use App\Enums\DocumentStatus;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Query\Builder;

class MoneyColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->money(currency: 'MXN')
            ->searchable()
            ->sortable()
            ->alignEnd()
            ->toggleable(isToggledHiddenByDefault: false)
            ->summarize(
                Sum::make()
                    ->money(currency: 'MXN', divideBy: 100)
                    ->query(fn (Builder $query): Builder => $query->where('status', DocumentStatus::Placed)),
            );
    }
}
