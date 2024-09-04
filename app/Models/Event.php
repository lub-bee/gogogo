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
        "start_at" => "datetime",
        "end_at" => "datetime",
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

    /**
     * Get the previous event that has been published.
     * The previous event is defined as the one with the most recent start date
     * that is before the current event's start date.
     * If there is no previous event, it returns null.
     *
     * @return Event|null
     */
    public function previous(): Event|null
    {
        return $this->where("start_at", "<", $this->start_at)
            ->where('published_at', '<=', Carbon::now())
            ->orderBy("start_at", "desc")
            ->first();
    }

    /**
     * Check if the event has a previous one.
     *
     * @return bool
     */
    public function hasPrevious(): bool
    {
        return $this->previous() != null;
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
