<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'rank'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // Rank constants
    public const RANK_ADMIN = 'admin';
    public const RANK_SUPPORT = 'support';
    public const RANK_MEMBER = 'member';

    public const RANKS = [
        self::RANK_ADMIN,
        self::RANK_SUPPORT,
        self::RANK_MEMBER,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if the user has the admin rank.
     */
    public function isAdmin(): bool
    {
        return $this->rank === self::RANK_ADMIN;
    }

    /**
     * Check if the user has the support rank.
     */
    public function isSupport(): bool
    {
        return $this->rank === self::RANK_SUPPORT;
    }

    /**
     * Check if the user has any of the given ranks.
     */
    public function hasRank(string ...$ranks): bool
    {
        return in_array($this->rank, $ranks, true);
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    /**
     * Events the user is attending (RSVP).
     */
    public function attendingEvents(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'attendances')
            ->withTimestamps();
    }
}
