<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Seeder;
use Tests\TestCase;
use App\Models\Post;

class PostTest extends TestCase
{

    private $post;

    // public function setUp(): void
    // {
    //     parent::setUp();
    //     $this->post = Post::factory()->create();
    //     Post::factory()->create();
    //     Post::factory()->create();
    //     Post::factory()->create();
    //     Post::factory()->create();
    // }

        /**
     * PostController tests 
     * returns a list of posts 
     * 
     * @return void
     */
    public function testGetAllPosts() 
    {
        $response = $this->get('/api/post/all');
        $response->assertStatus(200);
    }
}
