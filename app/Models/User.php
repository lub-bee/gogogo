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

    const RANK_VISITOR = "0";
    const RANK_SUPPORT = "10";
    const RANK_ADMIN = "100";
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

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function isAdmin(): bool
    {
        return $this->rank === self::RANK_ADMIN;
    }

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
