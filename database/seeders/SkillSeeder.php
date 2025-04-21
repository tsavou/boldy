<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            // Développement général
            'Développement web',
            'Développement frontend',
            'Développement backend',
            'Développement fullstack',
            'Développement mobile',
            'Intégration web',
            'Responsive design',
            'Accessibilité web',
            'Ergonomie web',
            'Cyber-sécurité',
            'Optimisation SEO',
            'Référencement naturel',
            'Marketing digital',
            'Gestion de projet',
            'Méthodologie Agile',
            'Création de sites web',
            'Application web',

            // Langages et tech
            'HTML', 'CSS', 'Sass / SCSS', 'JavaScript', 'TypeScript',
            'PHP', 'Python', 'Ruby', 'SQL', 'NoSQL', 'GraphQL', 'REST API',

            // Frameworks & outils
            'Laravel', 'Symfony', 'Node.js', 'Express.js', 'Django', 'Flask',
            'Vue.js', 'Nuxt.js', 'React', 'Next.js', 'Angular',
            'Tailwind CSS', 'Bootstrap',

            // CMS
            'WordPress', 'Webflow', 'Shopify', 'Prestashop',

            // Mobile
            'Flutter', 'React Native', 'Swift', 'Kotlin', 'Ionic',

            // Design & outils
            'Design UX', 'Design UI', 'Webdesign', 'Identité visuelle',
            'Branding', 'Figma', 'Adobe XD', 'Photoshop', 'Illustrator', 'InDesign',

            // Vidéo
            'Montage vidéo', 'Motion design', 'Premiere Pro', 'After Effects',

            // Marketing
            'SEO', 'SEA', 'Google Ads', 'Analytics', 'Copywriting', 'Community management',

            // Outils & devops
            'Git', 'GitHub', 'Docker', 'Notion', 'Slack', 'Zapier', 'Trello', 'Jira', 'Asana', 'ClickUp', 'AWS', 'Heroku', 'Netlify', 'Vercel', 'Firebase', 'Supabase', 'MySQL', 'PostgreSQL', 'MongoDB', 'Redis', 'Elasticsearch', 'API', 'WebSockets', 'Socket.io',

            // Soft skills
            'Communication', 'Créativité', 'Autonomie', 'Esprit d’équipe',
            'Organisation', 'Résolution de problèmes', 'Gestion du temps', 'Adaptabilité', 'Curiosité', 'Patience', 'Pédagogie',

            // Langues
            'Français', 'Anglais', 'Espagnol', 'Allemand', 'Italien',
            'Portugais', 'Arabe', 'Japonais', 'Chinois', 'Russe',
            'Hindi', 'Bengali', 'Punjabi', 'Turc', 'Néerlandais',

        ];

        foreach ($skills as $skill) {
            DB::table('skills')->insert([
                'name' => $skill,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
