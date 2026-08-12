<?php

namespace App\Models;

use App\Enums\MediaStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';

    protected $fillable = [
        'path',
        'thumbnail_path',
        'legend',
        'status',
        'user_id',
        'event_id',
    ];

    protected function casts(): array
    {
        return [
            'status' => MediaStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Approve this media item.
     */
    public function approve(): void
    {
        $this->update(['status' => MediaStatus::Approved]);
    }

    /**
     * Refuse this media item.
     *
     * Deletes the original full-size file from storage but keeps the thumbnail
     * so moderators and the uploader can still see what was refused.
     * The `path` column is set to null to reflect the deletion.
     */
    public function refuse(): void
    {
        // Delete original file if it exists
        if ($this->path && Storage::disk('public')->exists($this->path)) {
            Storage::disk('public')->delete($this->path);
        }

        $this->update([
            'status' => MediaStatus::Refused,
            'path' => null,
        ]);
    }
}
