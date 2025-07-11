<?php

namespace Database\Factories;

use App\Models\Boost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BoostFactory extends Factory
{
    protected $model = Boost::class;

    public function definition(): array
    {
        return [
            'start_date' => Carbon::now(),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
