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

        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'admin'],
            ['id' => 2, 'name' => 'freelance'],
        ]);

        Freelance::factory(10)->create();

        Profession::factory(10)->create();

        $this->call([
            SkillSeeder::class,
        ]);


        // User::factory(10)->create();
    }
}
