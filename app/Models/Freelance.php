<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Freelance extends Model
{
    use HasFactory;

    protected $table = 'freelances';

    protected $fillable = [
        'bio',
        'price_per_day',
        'location',
        'profile_picture',
        'cover_picture',
        'siret',
        'portfolio_url',
        'linkedin_url',
        'is_verified',
        'is_available',
        'user_id',
        'slug',
    ];

    protected static function boot(): void
    {
        parent::boot();
        // Generate slug before creating a new freelance
        static::creating(function ($freelance) {
            $freelance->slug = self::generateUniqueSlug($freelance->user->first_name, $freelance->user->name);
        });
        // Update slug before updating a freelance
        static::updating(function ($freelance) {
            $freelance->slug = self::generateUniqueSlug($freelance->user->first_name, $freelance->user->name);
        });
    }

    // Generate a unique slug based on first name and name
    public static function generateUniqueSlug($firstName, $name): string
    {
        $slug = Str::slug($firstName . ' ' . $name);
        $originalSlug = $slug;
        $count = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function professions(): BelongsToMany
    {
        return $this->belongsToMany(Profession::class, 'freelance_professions');
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'freelance_skills');
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class, 'freelance_id');
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(Experiences::class, 'freelance_id');
    }

    public function freelanceMedias(): HasMany
    {
        return $this->hasMany(FreelanceMedia::class, 'freelance_id');
    }

    public function boosts(): HasMany
    {
        return $this->hasMany(Boost::class, 'freelance_id');
    }
}
