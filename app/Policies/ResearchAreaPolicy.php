<?php

namespace App\Policies;

use App\Models\ResearchArea;
use App\Models\User;

class ResearchAreaPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }

    public function view(User $user, ResearchArea $researchArea): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, ResearchArea $researchArea): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, ResearchArea $researchArea): bool
    {
        return $user->role === 'admin';
    }
}
