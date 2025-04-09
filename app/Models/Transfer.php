<?php

namespace App\Models;

use App\Enums\TransferStatus;
use App\Traits\BelongsToTenant;
use App\Traits\HasFolio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transfer extends Model
{
    use BelongsToTenant;
    use HasFolio;

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'status' => TransferStatus::class,
        ];
    }

    /**
     * This method returns the user who created the transfer.
     *
     * @return BelongsTo<User>
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * This method returns the user who accepted the transfer.
     *
     * @return BelongsTo<User>
     */
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
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
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
