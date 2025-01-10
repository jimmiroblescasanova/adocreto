<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Filament\Facades\Filament;
use App\Enums\DocumentTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected function casts(): array
    {
        return [
            'subtotal' => MoneyCast::class,
            'tax' => MoneyCast::class,
            'total' => MoneyCast::class,
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

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
     * @param DocumentTypeEnum $type The type of document to count.
     * @return int The count of documents of the specified type.
     */
    public static function getFolio(DocumentTypeEnum $type): int
    {
        $company = Filament::getTenant();

        return self::whereBelongsTo($company)
            ->where('type', $type)
            ->count();
    }
}
