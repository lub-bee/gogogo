<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasFactory;

    const STATUS_PUBLISH = "published";
    const STATUS_DRAFT = "draft";
    const STATUS = [ self::STATUS_PUBLISH, self::STATUS_DRAFT ];


    public function user(): BelongsTo
    {
        return $this->belongsTo((User::class));
    }

    public function event(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
