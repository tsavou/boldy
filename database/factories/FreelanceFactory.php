<?php

namespace Database\Factories;

use App\Models\Freelance;
use App\Models\Role;
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
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ]);

        return [
            'bio' => $this->faker->word(),
            'price_per_day' => $this->faker->randomNumber(),
            'location' => $this->faker->city(),
            'profile_picture' => null,
            'cover_picture' => null,
            'siret' => $this->faker->numerify('##############'),
            'portfolio_url' => $this->faker->url(),
            'linkedin_url' => $this->faker->url(),
            'is_verified' => $this->faker->boolean(),
            'is_available' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'slug' => Freelance::generateUniqueSlug($user->first_name, $user->name),

            'user_id' => $user->id,
        ];
    }
}
