<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use HasFactory;

    const STATUS_DRAFT = "draft";
    const STATUS_SCHEDULED = "scheduled";
    const STATUS_PUBLISHED = "published";

    const STATUS = [
        self::STATUS_DRAFT,
        self::STATUS_SCHEDULED,
        self::STATUS_PUBLISHED,
    ];

    protected $casts = [
        "start_at" => "date",
    ];

    public function user(): BelongsTo
    {

        /*
        how to use in the view?
        $model->relatedtable()-> ...
        this comes before the database request

        $model->relatedtable->property
        this comes after the database request
        this gives you the model entity/property which you can use or see easily.
        */


        return $this->belongsTo(User::class);
    }

    public function topic(): HasOne
    {
        return $this->hasOne(Topic::class, "id", "topic_id");
    }

    public function location(): HasOne
    {
        return $this->hasOne(Location::class, "id", "location_id");
    }

    public function medias(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    public function scopeIsPublished($builder): void
    {
        $builder->whereNotNull("published_at")
            ->where("published_at", "<=", Carbon::now());
    }

    public function getPublishStatusAttribute(): string
    {
        if($this->published_at == null)
        {
            return self::STATUS_DRAFT;
        }
        elseif ( Carbon::now() < $this->published_at)
        {
            return self::STATUS_SCHEDULED;
        }
        else
        {
            return self::STATUS_PUBLISHED;
        }
    }

    public function isPublished(): bool
    {
        return $this->publish_status == self::STATUS_PUBLISHED;
    }

    public function isScheduled(): bool
    {
        return $this->publish_status == self::STATUS_SCHEDULED;
    }

    public function isDraft(): bool
    {
        return $this->publish_status == self::STATUS_DRAFT;
    }


}
