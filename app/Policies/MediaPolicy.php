<?php

namespace App\Policies;

use App\Models\Media;
use App\Models\User;

class MediaPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Media $media): bool
    {
        return true;
    }

    /**
     * Any authenticated user (including members) can upload media.
     */
    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Media $media): bool
    {
        return $user->hasRank(User::RANK_ADMIN, User::RANK_SUPPORT);
    }

    public function delete(User $user, Media $media): bool
    {
        return $user->hasRank(User::RANK_ADMIN, User::RANK_SUPPORT);
    }
}
