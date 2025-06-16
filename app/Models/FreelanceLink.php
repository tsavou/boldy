<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FreelanceLink extends Model
{
    protected $fillable = ['freelance_id', 'type', 'url'];

    public function freelance(): BelongsTo
    {
        return $this->belongsTo(Freelance::class);
    }
}
