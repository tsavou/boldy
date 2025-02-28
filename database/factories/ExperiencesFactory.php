<?php

namespace Database\Factories;

use App\Models\Experiences;
use App\Models\Freelance;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ExperiencesFactory extends Factory
{
    protected $model = Experiences::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'company' => $this->faker->company(),
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now(),
            'description' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'freelance_id' => Freelance::factory(),
        ];
    }
}
