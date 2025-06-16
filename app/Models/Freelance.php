<?php

namespace App\Models;

use App\Models\Scopes\ExperienceDataScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[ScopedBy([ExperienceDataScope::class])]
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
        'identity_document_path',
        'is_verified',
        'is_available',
        'user_id',
        'slug',
    ];

    protected $appends = ['full_name', 'first_name', 'is_premium'];

    protected static function boot(): void
    {
        parent::boot();
        // Generate slug before creating a new freelance
        static::creating(function ($freelance) {
            $freelance->slug = self::generateUniqueSlug($freelance->user->first_name, $freelance->user->name);
        });
        // Update slug before updating a freelance
        static::updating(function ($freelance) {
            if ($freelance->isDirty('user.first_name') || $freelance->isDirty('user.name')) {
                $freelance->slug = self::generateUniqueSlug($freelance->user->first_name, $freelance->user->name);
            }
        });
    }

    // Generate a unique slug based on first name and name
    public static function generateUniqueSlug($firstName, $name): string
    {
        $slug = Str::slug($firstName.' '.$name);
        $originalSlug = $slug;
        $count = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug.'-'.$count++;
        }

        return $slug;
    }

    public function getFullNameAttribute(): string
    {
        return $this->user->first_name.' '.$this->user->name;
    }

    public function getFirstNameAttribute(): string
    {
        return $this->user->first_name;
    }

    public function getIsPremiumAttribute(): bool
    {
        return $this->user->subscribed();
    }

    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('is_verified', true);
    }

    public function scopeBoosted(Builder $query)
    {
        return $query->whereHas('boosts', function ($query) {
            $query->where('end_date', '>', now());
            $query->where('start_date', '<', now());
        })
            ->where('is_verified', true);
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
        return $this->hasMany(Experience::class, 'freelance_id');
    }

    public function freelanceMedias(): HasMany
    {
        return $this->hasMany(FreelanceMedia::class, 'freelance_id');
    }

    public function boosts(): HasMany
    {
        return $this->hasMany(Boost::class, 'freelance_id');
    }

    public function links(): HasMany
    {
        return $this->hasMany(FreelanceLink::class, 'freelance_id');
    }
}
