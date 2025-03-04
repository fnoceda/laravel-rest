<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;
use Tests\TestCase;



class RegisterTest extends TestCase
{


    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $clientRepository = new ClientRepository();
        $clientRepository->createPasswordGrantClient(
            null,
            'Test Password Grant Client',
            'http://localhost'
        );
        $this->artisan('passport:client', [
            '--personal' => true,
            '--name' => 'Test Personal Access Client',
        ]);
    }

    public function test_register()
    {
        $this->withoutExceptionHandling();
        $response = $this->post(
            route('api.register'),
            [
                'fullname' => 'John Doe',
                'email' => 'fnoceda83@gmail.com',
                'role' => User::ADMINISTRADOR,
                'password' => 'password',
            ]
        );

        $response->assertStatus(200);
        $this->assertArrayHasKey('access_token', $response->json());
    }
}
