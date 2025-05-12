<?php

namespace Database\Seeders;

use App\Models\Freelance;
use Illuminate\Database\Seeder;

class FreelanceSeeder extends Seeder
{
    public function run(): void
    {
        Freelance::factory(40)->create();
    }
}
