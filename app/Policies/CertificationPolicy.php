<?php

namespace App\Policies;

use App\Models\Certification;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CertificationPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Certification $certification): bool
    {
        return $user->id === $certification->freelance->user_id;
    }
}
