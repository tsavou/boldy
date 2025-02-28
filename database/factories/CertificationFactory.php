<?php

namespace Database\Factories;

use App\Models\Certification;
use App\Models\Freelance;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CertificationFactory extends Factory
{
    protected $model = Certification::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'institution' => $this->faker->word(),
            'year' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'freelance_id' => Freelance::factory(),
        ];
    }
}
