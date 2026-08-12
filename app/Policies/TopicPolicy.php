<?php

namespace App\Policies;

use App\Models\Topic;
use App\Models\User;

class TopicPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Topic $topic): bool
    {
        if ($user->hasRank(User::RANK_ADMIN, User::RANK_SUPPORT)) {
            return true;
        }

        return $topic->isPublished();
    }

    public function create(User $user): bool
    {
        return $user->hasRank(User::RANK_ADMIN, User::RANK_SUPPORT);
    }

    public function update(User $user, Topic $topic): bool
    {
        return $user->hasRank(User::RANK_ADMIN, User::RANK_SUPPORT);
    }

    public function delete(User $user, Topic $topic): bool
    {
        return $user->hasRank(User::RANK_ADMIN, User::RANK_SUPPORT);
    }
}
