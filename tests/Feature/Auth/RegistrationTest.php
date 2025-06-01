<?php

namespace Tests\Feature\Auth;

use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register_and_create_freelance(): void
    {
        // Simule la soumission du formulaire d'inscription
        $response = $this->post('/register', [
            'name' => 'User',
            'first_name' => 'Test',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // Vérifie que l'utilisateur est bien authentifié
        $this->assertAuthenticated();

        // Récupère l'utilisateur connecté
        $user = Auth::user();

        // Vérifie qu'un freelance est bien créé et lié à cet utilisateur
        $this->assertDatabaseHas('freelances', [
            'user_id' => $user->id,
        ]);

        $freelance = $user->freelance;

        // Vérifie que le freelance existe bien
        $this->assertNotNull($freelance);

        $response->assertRedirect(route('freelance.show',$freelance->slug, absolute: false));
    }
}
