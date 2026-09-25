<?php

namespace App\Policies;

use App\Models\Publication;
use App\Models\User;

class PublicationPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function view(User $user, Publication $publication): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Publication $publication): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Publication $publication): bool
    {
        return $user->role === 'admin';
    }
}
