<?php

namespace App\Policies;

use App\Models\Freelance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FreelancePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update his freelance profile.
     *
     * @param  User  $user
     * @param  Freelance  $freelance
     * @return bool
     */
    public function update(User $user, Freelance $freelance): bool
    {
        return $user->id === $freelance->user_id;
    }

    /**
     * Determine whether the user can manage freelance profiles.
     *
     * @param  User  $user
     * @return bool
     */
    public function manage(User $user): bool
    {
        return $user->role->name === 'admin';
    }
}
