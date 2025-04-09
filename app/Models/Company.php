<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Company extends Model implements HasAvatar, HasMedia
{
    use InteractsWithMedia;

    protected function casts(): array
    {
        return [
            'tax' => MoneyCast::class,
        ];
    }

    /**
     * Get the categories associated with the company.
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Get the documents associated with the company.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Entity::class);
    }

    /**
     * Get the entities associated with the company.
     */
    public function entities(): HasMany
    {
        return $this->hasMany(Entity::class);
    }

    /**
     * Get the transfers associated with the company.
     */
    public function transfers(): HasMany
    {
        return $this->hasMany(Transfer::class);
    }

    /**
     * Get the price lists associated with the company.
     */
    public function priceLists(): HasMany
    {
        return $this->hasMany(PriceList::class);
    }

    /**
     * Get the productions associated with the company.
     */
    public function productions(): HasMany
    {
        return $this->hasMany(Production::class);
    }

    /**
     * Get the products associated with the company.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the units associated with the company.
     */
    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    /**
     * Get the warehouses associated with the company.
     */
    public function warehouses(): HasMany
    {
        return $this->hasMany(Warehouse::class);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->getFirstMediaUrl('company');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }
}
