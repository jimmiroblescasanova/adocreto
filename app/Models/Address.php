<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
    /**
     * Get the parent imageable model (client, supplier or document).
     */
    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
