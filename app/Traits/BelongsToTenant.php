<?php

namespace App\Traits;

use App\Models\Company;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTenant
{
    /**
     * Get the company that owns the model.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
