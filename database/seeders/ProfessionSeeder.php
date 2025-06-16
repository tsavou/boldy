<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Développeur web',
            'UX/UI Designer',
            'Graphiste',
            'Rédacteur web',
            'Community Manager',
            'Consultant SEO',
            'Traffic Manager',
            'Intégrateur web',
            'Vidéaste / Monteur vidéo',
            'Photographe',
            'Motion Designer',
            'Product Manager',
            'Growth Hacker',
            'Copywriter',
            'Webdesigner',
            'Social Media Manager',
            'Développeur mobile',
            'Consultant SEA',
            'Animateur 2D / 3D',
            'Data Analyst',
            'Data Scientist',
            'Formateur digital',
            'Coach business',
            'Développeur e-commerce',
            'Traducteur',
        ];

        foreach ($categories as $category) {
            DB::table('professions')->insert([
                'name' => $category,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
