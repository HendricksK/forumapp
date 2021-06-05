<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Seeder;
use Tests\TestCase;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Category;

class CommentTest extends TestCase
{

    private $comment;
    private $post;
    private $category;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->category = Category::factory()->create();
        Category::factory()->create();
        Category::factory()->create();
        Category::factory()->create();
        Category::factory()->create();

        $this->post = Post::factory()->create();
        Post::factory()->create();
        Post::factory()->create();
        Post::factory()->create();
        Post::factory()->create();

        $this->comment = Comment::factory()->create();
        Comment::factory()->create();
        Comment::factory()->create();
        Comment::factory()->create();
        Comment::factory()->create();
    }

    /**
     * CommentController tests 
     * returns a list of comments 
     * 
     * @return void
     */
    public function testGetAllComments() 
    {
        $response = $this->get('/api/comment/all');
        $response->assertStatus(200);
    }
}
