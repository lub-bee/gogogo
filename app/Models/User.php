<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const RANK_VISITOR = "visitor";
    const RANK_SUPPORT = "support";
    const RANK_ADMIN = "admin";
    const RANKS = [
        self::RANK_VISITOR,
        self::RANK_SUPPORT,
        self::RANK_ADMIN,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'rank' => 'string',
    ];

    /**
     * Retrieve the events associated with this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Check if the user has a specific role.
     *
     * @param string $role The role to check.
     * @return bool True if the user has the role, false otherwise.
     */
    public function hasRank(string $role): bool
    {
        return $this->rank === $role;
    }

    /**
     * Checks if the user is an admin.
     *
     * @return bool Returns true if the user has the admin role, false otherwise.
     */
    public function isAdmin(): bool
    {
        return $this->hasRank(self::RANK_ADMIN);
    }

    /**
     * Checks if the user is a support member.
     *
     * @return bool Returns true if the user has the support role, false otherwise.
     */
    public function isSupport(): bool
    {
        return $this->hasRank(self::RANK_SUPPORT);
    }

    /**
     * Checks if the user is a visitor.
     *
     * @return bool Returns true if the user has the visitor role, false otherwise.
     */
    public function isVisitor(): bool
    {
        return $this->hasRank(self::RANK_VISITOR);
    }

    /**
     * Returns a HasMany relationship for the medias associated with this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medias(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    /**
     * Returns the label corresponding to the given rank.
     *
     * @param int $rank The rank to get the label for.
     * @return string The label corresponding to the rank.
     */
    public static function rankLabel($rank): string
    {
        switch ($rank) {
            case self::RANK_ADMIN:
                return "admin";
            case self::RANK_SUPPORT:
                return "support";
            case self::RANK_VISITOR:
                return "visitor";
        }
    }

}
