<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Casts\QuantityCast;
use App\Enums\DocumentType;
use App\Enums\DocumentStatus;
use Filament\Facades\Filament;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Document extends Model
{
    use BelongsToTenant;
    
    protected function casts(): array
    {
        return [
            'type'      => DocumentType::class,
            'date'      => 'date',
            'quantity'  => QuantityCast::class,
            'price'     => MoneyCast::class,
            'subtotal'  => MoneyCast::class,
            'tax'       => MoneyCast::class,
            'total'     => MoneyCast::class,
            'status'    => DocumentStatus::class,
        ];
    }

    /**
     * Get the address associated with the document.
     *
     * @return MorphOne
     */
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    /**
     * Get the entity associated with the document.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    /**
     * Get the items associated with the document.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(DocumentItem::class);
    }

    /**
     * Get the production associated with the document.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function production(): HasOne
    {
        return $this->hasOne(Production::class);
    }

    /**
     * Get the user that owns the document.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the warehouse that owns the document.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Get the folio count for a specific document type.
     *
     * This method retrieves the count of documents of a given type that belong to the current tenant.
     *
     * @param DocumentType $type The type of document to count.
     * @return int The count of documents of the specified type.
     */
    public static function getFolio(DocumentType $type): int
    {
        $company = Filament::getTenant();

        return (int) self::whereBelongsTo($company)
            ->where('type', $type)
            ->max('folio') ?? 0;
    }
    
    /**
     * Returns the next available folio number.
     *
     * @return int
     */
    public static function getNextFolio(DocumentType $type): int
    {
        return self::getFolio($type) + 1;
    }
}
