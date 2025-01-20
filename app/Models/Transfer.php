<?php

namespace App\Models;

use Filament\Facades\Filament;
use App\Observers\TransferObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([TransferObserver::class])]
class Transfer extends Model
{
    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    /**
     * Get the company that owns the transfer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the items associated with the transfer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(TransferItem::class);
    }

    /**
     * Get the user that owns the transfer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the origin warehouse that owns the transfer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function originWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'origin_warehouse_id');
    }

    /**
     * Get the destination warehouse that owns the transfer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function destinationWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'destination_warehouse_id');
    }

    /**
     * Get the folio for a transfer.
     *
     * @return int The folio for the transfer.
     */
    public static function getFolio(): int
    {
        $company = Filament::getTenant();

        return self::whereBelongsTo($company)
            ->max('folio') ?? 0;
    }
}
