<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * Adds publication state management to a model.
 *
 * Requires a nullable `published_at` datetime column.
 */
trait Publishable
{
    public function isPublished(): bool
    {
        return $this->published_at !== null && ! $this->published_at->isFuture();
    }

    public function isDraft(): bool
    {
        return $this->published_at === null;
    }

    public function isScheduled(): bool
    {
        return $this->published_at !== null && $this->published_at->isFuture();
    }

    /**
     * Scope to only published records (published_at <= now).
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', Carbon::now());
    }

    /**
     * Publish the model immediately.
     */
    public function publish(): bool
    {
        $this->published_at = Carbon::now();

        return $this->save();
    }
}
