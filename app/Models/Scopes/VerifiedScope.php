<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class VerifiedScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (Auth::check()) {
            // Si l'utilisateur est connecté, on sélectionne les freelances vérifiés ou le freelance connecté
            $userId = Auth::id();

            $builder->where(function ($query) use ($userId) {
                $query->where('is_verified', true)
                    ->orWhere('user_id', $userId);
            });
            return;
        }

        $builder->where('is_verified', true);
    }
}
