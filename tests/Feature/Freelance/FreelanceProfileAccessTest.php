<?php

namespace Tests\Feature\Freelance;

use App\Models\Freelance;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FreelanceProfileAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_show()
    {
        $freelance = Freelance::factory()->create();

        $response = $this->get(route('freelance.show', $freelance->slug));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Freelance/Show')
            ->has('freelance')
            ->has('isEditable')
            ->has('professions')
            ->has('skills')
        );
    }

    public function test_unverified_profile_is_not_accessible()
    {
        $freelance = Freelance::factory()->create(['is_verified' => false]);

        $response = $this->get(route('freelance.show', $freelance->slug));
        $response->assertNotFound();
    }

    public function test_user_can_access_own_unverified_profile_and_edit_it()
    {
        $freelance = Freelance::factory()->create(['is_verified' => false]);
        $this->actingAs($freelance->user);

        $response = $this->get(route('freelance.show', $freelance->slug));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Freelance/Show')
            ->where('freelance.id', $freelance->id)
            ->where('isEditable', true)
        );
    }

    public function test_guest_cannot_access_private_routes()
    {
        $freelance = Freelance::factory()->create();

        $routes = [
            'freelance.updateImages' => 'post',
            'freelance.updateLocation' => 'put',
            'freelance.updateBio' => 'put',
            'freelance.updateInfos' => 'put',
            'freelances.updateProfessions' => 'put',
            'freelances.updateSkills' => 'put',
        ];

        foreach ($routes as $route => $method) {
            $response = $this->{$method}(route($route, $freelance));
            $response->assertRedirect(route('login'));
        }
    }
}
