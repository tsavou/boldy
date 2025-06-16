<?php

namespace Tests\Feature\Freelance;

use App\Models\Freelance;
use App\Models\Profession;
use App\Models\Skill;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FreelanceEditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_update_avatar()
    {
        Storage::fake('public');

        $freelance = Freelance::factory()->create();
        $user = $freelance->user;
        $this->actingAs($user);

        $response = $this->post(route('freelance.updateImages', $freelance), [
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Votre photo de profil a été mise à jour');

        Storage::disk('public')->assertExists('freelances/'.$freelance->slug.'-avatar');
    }

    public function test_update_cover()
    {
        Storage::fake('public');

        $freelance = Freelance::factory()->create();
        $user = $freelance->user;
        $this->actingAs($user);

        $response = $this->post(route('freelance.updateImages', $freelance), [
            'cover' => UploadedFile::fake()->image('cover.jpg'),
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Votre bannière a été mise à jour');

        Storage::disk('public')->assertExists('freelances/'.$freelance->slug.'-cover');
    }

    public function test_update_bio()
    {
        $freelance = Freelance::factory()->create();
        $user = $freelance->user;
        $this->actingAs($user);

        $response = $this->put(route('freelance.updateBio', $freelance), [
            'bio' => 'Nouvelle bio',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Votre bio a été mise à jour');
        $this->assertDatabaseHas('freelances', ['id' => $freelance->id, 'bio' => 'Nouvelle bio']);
    }

    public function test_update_skills()
    {
        $freelance = Freelance::factory()->create();
        $user = $freelance->user;
        $this->actingAs($user);

        $skills = Skill::factory()->count(3)->create();

        $response = $this->put(route('freelances.updateSkills', $freelance), [
            'skills' => $skills->pluck('id')->toArray(),
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Compétences mises à jour.');

        foreach ($skills as $skill) {
            $this->assertDatabaseHas('freelance_skills', [
                'freelance_id' => $freelance->id,
                'skill_id' => $skill->id,
            ]);
        }
    }

    public function test_update_infos()
    {
        $freelance = Freelance::factory()->create(['price_per_day' => 300, 'is_available' => false]);
        $this->actingAs($freelance->user);

        $response = $this->put(route('freelance.updateInfos', $freelance), [
            'price_per_day' => 500,
            'is_available' => true,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Informations mises à jour.');

        $this->assertDatabaseHas('freelances',
            ['id' => $freelance->id, 'price_per_day' => 500, 'is_available' => true]);
    }

    public function test_update_professions()
    {
        $freelance = Freelance::factory()->create();
        $user = $freelance->user;
        $this->actingAs($user);

        $professions = Profession::factory()->count(3)->create();

        $response = $this->put(route('freelances.updateProfessions', $freelance), [
            'professions' => $professions->pluck('id')->toArray(),
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Métiers mis à jour.');
        $this->assertCount(3, $freelance->professions);
        foreach ($professions as $profession) {
            $this->assertDatabaseHas('freelance_professions', [
                'freelance_id' => $freelance->id,
                'profession_id' => $profession->id,
            ]);
        }
    }

    public function test_verify_freelance()
    {
        Storage::fake('public');
        $freelance = Freelance::factory()->create(['siret' => null, 'identity_document_path' => null]);
        $this->actingAs($freelance->user);

        $file = UploadedFile::fake()->image('piece.png');

        $response = $this->post(route('freelance.verify'), [
            'siret' => '12345678901234',
            'identity_document' => $file,
        ]);

        $response->assertRedirect();
        $freelance->refresh();
        $this->assertEquals('12345678901234', $freelance->siret);
        $this->assertNotNull($freelance->identity_document_path);
        Storage::disk('public')->assertExists('identity_documents/'.$freelance->slug.'-ID');
    }

    public function test_update_location()
    {
        $freelance = Freelance::factory()->create();
        $user = $freelance->user;
        $this->actingAs($user);

        $response = $this->put(route('freelance.updateLocation', $freelance), [
            'location' => 'New York',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Votre localisation a été mise à jour');
        $this->assertDatabaseHas('freelances', ['id' => $freelance->id, 'location' => 'New York']);
    }
}
