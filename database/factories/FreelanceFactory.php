<?php

namespace Database\Factories;

use App\Models\Freelance;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FreelanceFactory extends Factory
{
    protected $model = Freelance::class;

    public function definition(): array
    {
        return [
            'bio' => $this->faker->word(),
            'price_per_day' => $this->faker->randomNumber(),
            'location' => $this->faker->word(),
            'profile_picture' => $this->faker->word(),
            'cover_picture' => $this->faker->word(),
            'siret' => $this->faker->word(),
            'portfolio_url' => $this->faker->url(),
            'linkedin_url' => $this->faker->url(),
            'is_verified' => $this->faker->boolean(),
            'is_available' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
