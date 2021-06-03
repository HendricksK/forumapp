<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\UserController;
use App\Models\User;

class CategoryTest extends TestCase
{
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
     * CategoryController tests 
     * returns a list of comments 
     * 
     * @return void
     */
    public function testGetAllCategory() 
    {
        $response = $this->get('/api/category/all');
        $response->assertStatus(200);
    }
}
