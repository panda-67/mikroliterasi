<?php

namespace App\Policies;

use App\Models\TeachingMaterial;
use App\Models\User;

class TeachingMaterialPolicy
{
    /**
     * Determine whether the user can view any teaching materials.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [
            'admin',
            'editor',
            'student',
        ], true);
    }

    /**
     * Determine whether the user can view a teaching material.
     */
    public function view(User $user, TeachingMaterial $teachingMaterial): bool
    {
        return true;
    }

    /**
     * Determine whether the user can access the PPT link.
     */
    public function viewPpt(User $user, TeachingMaterial $teachingMaterial): bool
    {
        return in_array($user->role, [
            'admin',
            'editor',
            'student',
        ], true);
    }

    /**
     * Determine whether the user can create teaching materials.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, [
            'admin',
            'editor',
        ], true);
    }

    /**
     * Determine whether the user can update the teaching material.
     */
    public function update(
        User $user,
        TeachingMaterial $teachingMaterial
    ): bool {
        return in_array($user->role, [
            'admin',
            'editor',
        ], true);
    }

    /**
     * Determine whether the user can delete the teaching material.
     */
    public function delete(
        User $user,
        TeachingMaterial $teachingMaterial
    ): bool {
        return in_array($user->role, [
            'admin',
            'editor',
        ], true);
    }
}
