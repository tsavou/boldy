<?php

namespace Database\Factories;

use App\Models\Experience;
use App\Models\Freelance;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ExperienceFactory extends Factory
{
    protected $model = Experience::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle(),
            'company' => $this->faker->company(),
            'start_date' => Carbon::now()->subMonths(6),
            'end_date' => Carbon::now(),
            'description' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
