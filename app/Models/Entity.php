<?php

namespace App\Models;

use App\Enums\IsActive;
use App\Enums\EntityType;
use Illuminate\Support\Str;
use App\Models\Cfdi40\UsoCfdi;
use Filament\Facades\Filament;
use App\Traits\BelongsToTenant;
use App\Traits\HasActiveSorting;
use App\Models\Cfdi40\RegimenFiscal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entity extends Model
{
    /** @use HasFactory<\Database\Factories\EntityFactory> */
    use HasFactory;
    use BelongsToTenant;
    use HasActiveSorting;

    protected function casts()
    {
        return [
            'active' => IsActive::class,
        ];
    }

    /**
     * Get all of the addresses for the entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    /**
     * Get the regimen fiscal for the entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function regimenFiscal(): BelongsTo
    {
        return $this->belongsTo(RegimenFiscal::class);
    }

    /**
     * Get the uso cfdi for the entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usoCfdi(): BelongsTo
    {
        return $this->belongsTo(UsoCfdi::class);
    }

    /**
     * Scope a query to only include clients.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeClients(Builder $query): Builder
    {
        return $query->where('type', EntityType::Client);
    }

    /**
     * Scope a query to only include suppliers.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeSuppliers(Builder $query): Builder
    {
        return $query->where('type', EntityType::Supplier);
    }

    /**
     * Verify if the client already have a billing address.
     *
     * @return bool
     */
    public function hasBillingAddress(): bool
    {
        return $this->addresses()->where('type', 1)->exists();
    }

    /**
     * Get the next code for the given type.
     *
     * @param EntityType $type
     * @return int
     */
    public static function getNextCode(EntityType $type): int
    {
        $tenant = Filament::getTenant();

        return self::query()
            ->where('company_id', $tenant->id)
            ->where('type', $type)
            ->max('code') + 1;
    }

    /**
     * Set the client's name attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::upper($value)
        );
    }

    /**
     * Set the client's RFC attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function rfc(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::upper($value)
        );
    }
}
