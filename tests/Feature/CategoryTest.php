<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Seeder;
use Tests\TestCase;
use App\Models\Category;

class CategoryTest extends TestCase
{
    private $category;

    public function setUp(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
        Category::factory()->create();
        Category::factory()->create();
        Category::factory()->create();
        Category::factory()->create();
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
