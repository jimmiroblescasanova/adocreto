<?php

namespace App\Models;

use App\Enums\ProductionStatus;
use App\Traits\BelongsToTenant;
use App\Traits\HasFolio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Production extends Model
{
    use BelongsToTenant;
    use HasFolio;

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'status' => ProductionStatus::class,
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
        ];
    }

    /**
     * This method returns the items of the production.
     *
     * @return HasMany<ProductionItems>
     */
    public function items(): HasMany
    {
        return $this->hasMany(ProductionItems::class);
    }

    /**
     * Get the components associated with the production.
     */
    public function components(): HasMany
    {
        return $this->hasMany(ProductionComponent::class);
    }

    /**
     * This method returns the origin warehouse of the production.
     *
     * @return BelongsTo<Warehouse>
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    /**
     * This method returns the user who started the production.
     *
     * @return BelongsTo<User>
     */
    public function startedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'started_by');
    }

    /**
     * This method returns the user who ended the production.
     *
     * @return BelongsTo<User>
     */
    public function endedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ended_by');
    }

    /**
     * This method returns the user who created the production.
     *
     * @return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
