<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_access_for_stagiaires()
    {
        $response = $this->get(route('public.index'));
        $response->assertStatus(200);
    }

    public function test_restricted_access_for_formateurs()
    {
        $formateur = User::create([
            'name' => 'Formateur',
            'email' => 'formateur@test.com',
            'password' => bcrypt('password'),
            'role' => 'formateur'
        ]);

        // Un formateur ne peut pas accéder aux pages admin
        $response = $this->actingAs($formateur)->get(route('seances.create'));
        $response->assertStatus(403);
    }

    public function test_admin_access()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
    }
}
