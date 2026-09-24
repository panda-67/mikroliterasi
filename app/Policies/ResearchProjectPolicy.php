<?php

namespace App\Policies;

use App\Models\ResearchProject;
use App\Models\User;

class ResearchProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function view(User $user, ResearchProject $researchProject): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, ResearchProject $researchProject): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, ResearchProject $researchProject): bool
    {
        return $user->role === 'admin';
    }
}
