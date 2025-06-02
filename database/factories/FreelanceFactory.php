<?php

namespace Database\Factories;

use App\Models\Boost;
use App\Models\Certification;
use App\Models\Experience;
use App\Models\Freelance;
use App\Models\Profession;
use App\Models\Role;
use App\Models\Skill;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FreelanceFactory extends Factory
{
    protected $model = Freelance::class;

    public function definition(): array
    {
        $user = User::factory()->create([
            'role_id' => Role::where('name', 'freelance')->first()->id,
            'first_name' => $this->faker->firstName(),
            'name' => $this->faker->lastName(),
            'email' => function (array $attributes) {
                return strtolower($attributes['first_name'] . '.' . $attributes['name'] . '@example.com');
            },
            'password' => bcrypt('password'),
        ]);

        return [
            'bio' => $this->faker->paragraph(),
            'price_per_day' => $this->faker->biasedNumberBetween(200, 1000),
            'location' => $this->faker->city(),
            'profile_picture' => null,
            'cover_picture' => null,
            'siret' => $this->faker->numerify('##############'),
            'is_verified' => true,
            'is_available' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'slug' => Freelance::generateUniqueSlug($user->first_name, $user->name),

            'user_id' => $user->id,
        ];
    }

    public function configure(): FreelanceFactory
    {
        return $this->afterCreating(function (Freelance $freelance) {
            $freelance->skills()->attach(Skill::inRandomOrder()->take(3)->pluck('id'));
            $freelance->professions()->attach(Profession::inRandomOrder()->take(1)->pluck('id'));
            $freelance->certifications()->saveMany(Certification::factory()->count(3)->make());
            $freelance->experiences()->saveMany(Experience::factory()->count(3)->make());

            if ($this->faker->boolean()) {
                $freelance->boosts()->save(Boost::factory()->make());
            }

            if ($this->faker->boolean()) {
                $freelance->user->subscription()->save(Subscription::factory()->make());
            }
        });
    }
}
