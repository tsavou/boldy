<?php

namespace App\Policies;

use App\Models\FreelanceLink;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FreelanceLinkPolicy
{
    use HandlesAuthorization;

    public function update(User $user, FreelanceLink $link): bool
    {
        return $user->id === $link->freelance->user_id;
    }
}
