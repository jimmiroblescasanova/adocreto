<?php

namespace App\Models;

use App\Enums\EntityType;
use App\Enums\IsActive;
use App\Models\Cfdi40\RegimenFiscal;
use App\Models\Cfdi40\UsoCfdi;
use App\Traits\BelongsToTenant;
use App\Traits\HasActiveSorting;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Entity extends Model
{
    use BelongsToTenant;

    use HasActiveSorting;
    /** @use HasFactory<\Database\Factories\EntityFactory> */
    use HasFactory;

    protected function casts()
    {
        return [
            'active' => IsActive::class,
        ];
    }

    /**
     * Get all of the addresses for the entity.
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    /**
     * Get the regimen fiscal for the entity.
     */
    public function regimenFiscal(): BelongsTo
    {
        return $this->belongsTo(RegimenFiscal::class);
    }

    /**
     * Get the uso cfdi for the entity.
     */
    public function usoCfdi(): BelongsTo
    {
        return $this->belongsTo(UsoCfdi::class);
    }

    /**
     * Scope a query to only include clients.
     */
    public function scopeClients(Builder $query): Builder
    {
        return $query->where('type', EntityType::Client);
    }

    /**
     * Scope a query to only include suppliers.
     */
    public function scopeSuppliers(Builder $query): Builder
    {
        return $query->where('type', EntityType::Supplier);
    }

    /**
     * Verify if the client already have a billing address.
     */
    public function hasBillingAddress(): bool
    {
        return $this->addresses()->where('type', 1)->exists();
    }

    /**
     * Get the next code for the given type.
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
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::upper($value)
        );
    }

    /**
     * Set the client's RFC attribute.
     */
    protected function rfc(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::upper($value)
        );
    }
}
