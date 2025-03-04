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
        $this->withoutExceptionHandling();

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

        $user = User::updateOrCreate(
            ['email' => 'fnoceda@gmail.com'],
            [
                'fullname' => 'Francisco Noceda',
                'email' => 'fnoceda@gmail.com',
                'password' => bcrypt('password')
            ]
        );

        $response = $this->post(route('api.login'), [
            'email' => 'fnoceda@gmail.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('access_token', $response->json());
    }


    /**
     * Test the logout functionality.
     * This function sends a POST request to the logout endpoint to simulate a user logging out.//+
     * It verifies that the logout is successful by checking the response status code.//+
     * @return void//+
     */  public function autenticate()
    {
        $user = User::updateOrCreate(
            ['email' => 'fnoceda@gmail.com'],
            [
                'fullname' => 'Francisco Noceda',
                'email' => 'fnoceda@gmail.com',
                'password' => bcrypt('password')
            ]
        );

        if(!auth()->attempt(['email' => $user->email, 'password' => 'password'])){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $user->createToken('authToken')->accessToken;

    }


     public function test_logout()
     {
        $token = $this->autenticate();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get(route('api.auth.logout'));

        $response->assertStatus(200);
        $this->assertArrayHasKey('message', $response->json());
        $this->assertEquals($response->json()['message'], 'Successfully logged out');
     }



     public function test_user_can_retrived()
     {
        $token = $this->autenticate();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get(route('api.auth.me'));

        $response->assertStatus(200);
        $this->assertArrayHasKey('user', $response->json());
     }

}
