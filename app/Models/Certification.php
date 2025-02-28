<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'institution',
        'year',
        'freelance_id',
    ];

    public function freelance(): BelongsTo
    {
        return $this->belongsTo(Freelance::class);
    }

    protected function casts(): array
    {
        return [
            'year' => 'integer',
        ];
    }
}
