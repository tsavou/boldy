<?php

namespace Database\Factories;

use App\Enums\SubscriptionPlanEnum;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        $plan = $this->faker->randomElement(SubscriptionPlanEnum::cases());

        return [
            'plan' => $plan,
            'start_date' => Carbon::now(),
            'price' => $plan->price(),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
