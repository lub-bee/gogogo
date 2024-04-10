<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $table = "medias";

    protected $casts = [
        'validated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo((User::class));
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo((Event::class));
    }

    public function getValidatedAttribute()
    {
        return $this->validated_at != null;
    }

    public function scopeIsValidated($query)
    {
        return $query->whereNotNull('validated_at');
    }

    public function scopeIsNotValidated($query)
    {
        return $query->whereNull('validated_at');
    }

    public function getPathUrlAttribute()
    {
        return Storage::url($this->path);
    }
}
