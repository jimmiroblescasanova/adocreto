<?php

namespace App\Models;

use App\Traits\HasFolio;
use App\Enums\TransferStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transfer extends Model
{
    use HasFolio;

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'status' => TransferStatus::class,
        ];
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function acceptedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'accepted_by');
    }

    /**
     * This method returns the destination warehouse for the transfer.
     *
     * @return BelongsTo<Warehouse>
     */
    public function destinationWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'destination_warehouse_id');
    }

    /**
     * This method returns the origin warehouse for the transfer.
     *
     * @return BelongsTo<Warehouse>
     */
    public function originWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'origin_warehouse_id');
    }

    /**
     * This method returns the items for the transfer.
     *
     * @return HasMany<TransferItem>
     */
    public function items(): HasMany
    {
        return $this->hasMany(TransferItem::class);
    }

}
