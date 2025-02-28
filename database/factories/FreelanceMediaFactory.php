<?php

namespace Database\Factories;

use App\Models\Freelance;
use App\Models\FreelanceMedia;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FreelanceMediaFactory extends Factory
{
    protected $model = FreelanceMedia::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->word(),
            'url' => $this->faker->url(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'freelance_id' => Freelance::factory(),
        ];
    }
}
