<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasFactory;

    protected $cast = [
        "published_at" => "datetime",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo((User::class));
    }

    public function event(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * this is a scope, it's used to add specific conditions over
     * a request from the database.
     * For example, when you get all the topics, if you call this scope
     * it will only return the topics that are published
     *
     * example : $topics = Topic::isPublished()->get();
     */
    public function scopeIsPublished($builder): void
    {
        $builder->whereNotNull("published_at")
            ->where("published_at", "<=", Carbon::now());
    }

    /**
     * This is a custom attribute. It's like a property
     * of the model (like the one that are defined on the migration file : name, title, ...)
     * But this one is not stored in the database, it's only computed
     *
     * Here, we use a field that exists in the DB (published_at), and based on
     * its content, we can defined the publish_status of it
     *  - if empty : draft
     *  - if passed date : published
     *  - if future date : scheduled
     */
    public function getPublishStatusAttribute(): string
    {
        if ($this->published_at == null)
        {
            return "draft";
        }
        elseif( Carbon::now() < $this->published_at)
        {
            return "scheduled";
        }
        else
        {
            return "published";
        }
    }

    /**
     * these function are used to to simplify the code in the controller/view
     * with a simple function returning a boolean
     */
    public function isPublished(): bool
    {
        return $this->publish_status == "published";
    }

    public function isScheduled(): bool
    {
        return $this->publish_status == "scheduled";
    }

    public function isDraft(): bool
    {
        return $this->publish_status == "draft";
    }

}
