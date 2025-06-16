<?php

namespace Tests\Feature\Freelance;

use App\Models\Freelance;
use App\Models\Skill;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FreelanceCatalogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function testIndex()
    {
        $response = $this->get(route('freelance.index'));

        $response->assertOk();
        $response->assertInertia(fn($page) => $page->component('Freelance/Index')
            ->has('freelances')
            ->has('professions')
            ->has('skills')
            ->has('cities')
            ->has('activeFilters')
        );
    }

    public function testOnlyVerifiedFreelancesAreVisibleInCatalog()
    {
        $verifiedFreelance = Freelance::factory()->create(['is_verified' => true]);
        $unverifiedFreelance = Freelance::factory()->create(['is_verified' => false]);

        $response = $this->get(route('freelance.index'));

        $response->assertOk();
        $response->assertInertia(fn($page) =>
        $page->has('freelances.data')
            ->where('freelances.data', fn($freelances) =>
                collect($freelances)->contains('id', $verifiedFreelance->id) &&
                collect($freelances)->doesntContain('id', $unverifiedFreelance->id)
            )
        );
    }

    public function testBoostedFreelancesAppearFirstInCatalog()
    {
        $nonBoosted = Freelance::factory()->create(['is_verified' => true]);
        $nonBoosted->boosts()->delete(); // s'assure qu'il n'est pas boosté

        $boosted = Freelance::factory()->create(['is_verified' => true]);
        $boosted->boosts()->create([
            'start_date' => now()->subDay(),
            'end_date' => now()->addDay(),
        ]);

        $response = $this->get(route('freelance.index'));

        // Vérifie que le freelance boosté apparaît en premier
        $response->assertOk();
        $response->assertInertia(fn($page) =>
        $page->has('freelances.data')
            ->where('freelances.data.0.id', $boosted->id)
        );
    }

    public function testFreelancesFiltersBySkill()
    {
        // Créer un freelance avec une compétence spécifique
        $skill = Skill::factory()->create(['name' => 'Laravel']);
        $freelanceWithSkill = Freelance::factory()->create();
        $freelanceWithSkill->skills()->sync([$skill->id]); //

        // Créer un freelance sans la compétence spécifique
        $freelanceWithoutSkill = Freelance::factory()->create();
        $freelanceWithoutSkill->skills()->sync([]); // s'assurer qu'il n'a pas de compétences

        // Effectuer une requête GET à la route 'freelance.index' avec le filtre de compétence
        $response = $this->get(route('freelance.index', ['skill' => 'Laravel']));

        // Vérifier que la réponse contient uniquement le freelance avec la compétence spécifique
        $response->assertOk();
        $response->assertInertia(fn ($page) =>
        $page->has('freelances.data', 1)
            ->where('freelances.data.0.id', $freelanceWithSkill->id)
        );
    }

    public function testFreelancesFiltersByCity()
    {
        $freelanceInParis = Freelance::factory()->create(['location' => 'Paris']);
        $freelanceInLyon = Freelance::factory()->create(['location' => 'Lyon']);

        $response = $this->get(route('freelance.index', ['city' => 'Paris']));

        $response->assertOk();
        $response->assertInertia(fn ($page) =>
        $page->has('freelances.data', 1)
            ->where('freelances.data.0.id', $freelanceInParis->id)
        );
    }

    public function testFreelancesFiltersByAvailability()
    {
        $availableFreelance = Freelance::factory()->create(['is_available' => true]);
        $unavailableFreelance = Freelance::factory()->create(['is_available' => false]);

        $response = $this->get(route('freelance.index', ['available' => true]));

        $response->assertOk();
        $response->assertInertia(fn ($page) =>
        $page->has('freelances.data')
            ->where('freelances.data.0.id', $availableFreelance->id)
        );
    }

    public function testFreelancesFiltersByMinPrice()
    {
        $freelanceCheap = Freelance::factory()->create(['price_per_day' => 200]);
        $freelanceExpensive = Freelance::factory()->create(['price_per_day' => 800]);

        $response = $this->get(route('freelance.index', ['min_price' => 500]));

        $response->assertOk();
        $response->assertInertia(fn ($page) =>
        $page->has('freelances.data')
            ->where('freelances.data.0.id', $freelanceExpensive->id)
        );
    }

    public function testFreelancesFiltersByMaxPrice()
    {
        $freelanceCheap = Freelance::factory()->create(['price_per_day' => 200]);
        $freelanceExpensive = Freelance::factory()->create(['price_per_day' => 800]);

        $response = $this->get(route('freelance.index', ['max_price' => 300]));

        $response->assertOk();
        $response->assertInertia(fn ($page) =>
        $page->has('freelances.data')
            ->where('freelances.data.0.id', $freelanceCheap->id)
        );
    }

    public function testFreelancesFiltersBySearch()
    {
        $freelance = Freelance::factory()->create();
        $freelance->user->update(['first_name' => 'Toto']);

        $response = $this->get(route('freelance.index', ['search' => 'Toto']));

        $response->assertOk();
        $response->assertInertia(fn ($page) =>
        $page->has('freelances.data')
            ->where('freelances.data.0.id', $freelance->id)
        );
    }

    public function testFreelancesSortedByPriceAsc()
    {
        $low = Freelance::factory()->create(['price_per_day' => 100, 'is_verified' => true]);
        $high = Freelance::factory()->create(['price_per_day' => 500, 'is_verified' => true]);

        $response = $this->get(route('freelance.index', ['sort' => 'price_asc']));

        $response->assertOk();
        $response->assertInertia(fn($page) =>
        $page->has('freelances.data')
            ->where('freelances.data.0.id', $low->id)
        );
    }

    public function testFreelancesFilteredByExperienceLevel()
    {
        $junior = Freelance::factory()->create(['is_verified' => true]);
        $junior->experiences()->createMany([
            ['title' => 'Dev', 'company' => 'A', 'start_date' => now()->subMonths(6), 'end_date' => now()],
        ]);

        $expert = Freelance::factory()->create(['is_verified' => true]);
        $expert->experiences()->createMany([
            ['title' => 'Dev', 'company' => 'B', 'start_date' => now()->subYears(5), 'end_date' => now()],
        ]);

        $response = $this->get(route('freelance.index', ['level' => ['Expert']]));

        $response->assertOk();
        $response->assertInertia(fn($page) =>
        $page->has('freelances.data')
            ->where('freelances.data.0.id', $expert->id)
        );
    }

    public function testFreelancesFilteredByMinAndMaxExperience()
    {
        $mid = Freelance::factory()->create(['is_verified' => true]);
        $mid->experiences()->createMany([
            ['title' => 'Dev', 'company' => 'C', 'start_date' => now()->subYears(2), 'end_date' => now()],
        ]);

        $expert = Freelance::factory()->create(['is_verified' => true]);
        $expert->experiences()->createMany([
            ['title' => 'Lead', 'company' => 'D', 'start_date' => now()->subYears(7), 'end_date' => now()],
        ]);

        $response = $this->get(route('freelance.index', ['min_exp' => 3, 'max_exp' => 8]));

        $response->assertOk();
        $response->assertInertia(fn($page) =>
        $page->has('freelances.data')
            ->where('freelances.data', fn($freelances) =>
                collect($freelances)->contains('id', $expert->id))
        );
    }

}
