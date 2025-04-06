<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Profession extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function freelances(): BelongsToMany
    {
        return $this->belongsToMany(Freelance::class, 'freelance_professions');
    }
}
