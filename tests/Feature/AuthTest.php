<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AuthTest extends TestCase
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



    /**
     * login test
     */
    public function test_login()
    {

        $this->withoutExceptionHandling();

        $user = User::updateOrCreate(
            ['email' => 'fnoceda@gmail.com'],
            [
                'fullname' => 'Francisco Noceda',
                'email' => 'fnoceda@gmail.com',
                'password' => bcrypt('password')
            ]
        );

        // $user->createToken('foo')->accessToken;

        $response = $this->post(route('api.login'), [
            'email' => 'fnoceda@gmail.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200);


    }
}
