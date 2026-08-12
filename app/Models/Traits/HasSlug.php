<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

/**
 * Auto-generates a slug from the `name` attribute on creation if not already set.
 */
trait HasSlug
{
    public static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug) && ! empty($model->name)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    /**
     * Get the route key name for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
