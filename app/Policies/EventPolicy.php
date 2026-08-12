<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    /**
     * Members can only see published events; admin/support see all.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Event $event): bool
    {
        if ($user->hasRank(User::RANK_ADMIN, User::RANK_SUPPORT)) {
            return true;
        }

        return $event->isPublished();
    }

    public function create(User $user): bool
    {
        return $user->hasRank(User::RANK_ADMIN, User::RANK_SUPPORT);
    }

    public function update(User $user, Event $event): bool
    {
        return $user->hasRank(User::RANK_ADMIN, User::RANK_SUPPORT);
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->hasRank(User::RANK_ADMIN, User::RANK_SUPPORT);
    }
}
