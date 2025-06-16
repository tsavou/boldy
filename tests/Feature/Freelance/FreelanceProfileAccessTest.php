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

    public function testShow()
    {
        $freelance = Freelance::factory()->create();

        $response = $this->get(route('freelance.show', $freelance->slug));

        $response->assertOk();
        $response->assertInertia(fn($page) => $page->component('Freelance/Show')
            ->has('freelance')
            ->has('isEditable')
            ->has('professions')
            ->has('skills')
        );
    }


    public function testUnverifiedProfileIsNotAccessible()
    {
        $freelance = Freelance::factory()->create(['is_verified' => false]);

        $response = $this->get(route('freelance.show', $freelance->slug));
        $response->assertNotFound();
    }

    public function testUserCanAccessOwnUnverifiedProfileAndEditIt()
    {
        $freelance = Freelance::factory()->create(['is_verified' => false]);
        $this->actingAs($freelance->user);

        $response = $this->get(route('freelance.show', $freelance->slug));

        $response->assertOk();
        $response->assertInertia(fn($page) => $page->component('Freelance/Show')
            ->where('freelance.id', $freelance->id)
            ->where('isEditable', true)
        );
    }

    public function testGuestCannotAccessPrivateRoutes()
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
