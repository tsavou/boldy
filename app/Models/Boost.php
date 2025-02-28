<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Boost extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'freelance_id',
    ];

    public function freelance(): BelongsTo
    {
        return $this->belongsTo(Freelance::class);
    }

    protected function casts(): array
    {
        return [
            'start_date' => 'timestamp',
            'end_date' => 'timestamp',
        ];
    }
}
