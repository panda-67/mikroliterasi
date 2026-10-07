<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function view(User $user, Post $post): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function update(User $user, Post $post): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->role === 'admin';
    }
}
