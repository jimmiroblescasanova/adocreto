<?php

namespace App\Models\Cfdi40;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class UsoCfdi extends Model
{
    protected $table = 'cfdi_40_usos_cfdi';

    protected function casts()
    {
        return [
            'aplica_fisica' => 'boolean',
            'aplica_moral' => 'boolean',
            'vigencia_desde' => 'date:Y-m-d',
            'vigencia_hasta' => 'date:Y-m-d',
            'regimenes_fiscales_receptores' => 'json',
        ];
    }

    /**
     * Scope a query to only include records where 'aplica_fisica' is true.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFisica(Builder $query): Builder 
    {
        return $query->where('aplica_fisica', true);
    }

    /**
     * Scope a query to only include records where 'aplica_moral' is true.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMoral(Builder $query): Builder 
    {
        return $query->where('aplica_moral', true);
    }
}
