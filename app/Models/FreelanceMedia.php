<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FreelanceMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'url',
        'freelance_id',
    ];

    public function freelance(): BelongsTo
    {
        return $this->belongsTo(Freelance::class);
    }
}
