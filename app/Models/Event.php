<?php

namespace App\Models;

use App\Enums\EventType;
use App\Models\Traits\HasSlug;
use App\Models\Traits\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory, HasSlug, Publishable;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'start_at',
        'end_at',
        'description_en',
        'description_ja',
        'published_at',
        'cost',
        'source_doc_id',
        'topic_id',
        'location_id',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'type' => EventType::class,
            'start_at' => 'datetime',
            'end_at' => 'datetime',
            'published_at' => 'datetime',
            'cost' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    public function attendees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'attendances')
            ->withTimestamps();
    }
}
