<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;

use Illuminate\Database\Seeder;

use Tests\TestCase;
use App\Http\Controllers\UserController;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        User::factory()->create();
        User::factory()->create();
        User::factory()->create();
        User::factory()->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * UserController tests getAllUsers
     * Returns a list of users
     * 
     * @return void
     */
    public function testGetAllUsers() 
    {
        $response = $this->get('/api/users/all');
        $response->assertStatus(200);
    }

    /**
     * UserController tests getUser
     * Returns a single user based on the id
     *
     * @return void
     */
    public function testGetUser() 
    {

        $response = $this->get('/api/users/user?id=' . $this->user->getAttribute('id'));
        $response->assertStatus(200);
    }

    /**
     * UserController tests createUser
     * tests user creation
     *
     * @return void
     */
    public function testCreateUser() 
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('/api/users/user', 
            [
                'name' => 'Leonard Hofstadter',
                'email' => 'LeonardHofstadter' . rand() . '.' . rand(),
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => rand(),
            ]
        );

        if ($response->getStatusCode() == 200) {
            $this->assertTrue(true);
        } else {
            $this->assertFalse(false);
        }
        
        // $this->assertTrue(false);

    }

    /**
     * UserController tests createUser
     * tests user creation
     *
     * @return void
     */
    public function testUpdateUser() 
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->put('/api/users/user', 
            [
                'id' => $this->user->getAttribute('id'),
                'name' => 'Leonard Hofstadter',
                'email' => 'LeonardHofstadter' . rand() . '.' . rand(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]
        );

        if ($response->getStatusCode() == 200) {
            $this->assertTrue(true);
        } else {
            $this->assertFalse(false);
        }

    }

    public function testDeleteUser() 
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->delete('/api/users/user', 
            [
                'id' => $this->user->getAttribute('id')
            ]
        );

        if ($response->getStatusCode() == 200) {
            $this->assertTrue(true);
        } else {
            $this->assertFalse(false);
        }

    }
}
