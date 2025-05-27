<?php

namespace Database\Seeders;

use App\Models\Freelance;
use App\Models\Profession;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\FreelanceFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            SkillSeeder::class,
            ProfessionSeeder::class,
            FreelanceSeeder::class
        ]);
    }
}
