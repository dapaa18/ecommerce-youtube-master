<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Models\Product;
use Tests\TestCase;

class TagTest extends TestCase
{


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTag_abc()
    {
        $request = new Request(); // Create a new Request object if needed
        $slug = 'example-slug'; // Set a slug for testing

        // Perform the necessary operations to prepare the product
        // You can use the factory method or directly create an instance of the product

        // For example, using a factory:
        Product::factory()->create(['slug' => $slug]);

        // Perform the operation to retrieve products matching the tag criteria
        $products = Product::with('tags')
            ->whereHas('tags', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })
            ->orderBy('id', 'asc') // Replace with the appropriate field and sort type
            ->paginate(6);

        // Perform an HTTP GET request to the appropriate endpoint
        $response = $this->get('/');

        // Check if the response is successful
        $response->assertStatus(200);

        // If this test is for a unit test case, you can also check the response content
        // $response->assertSee('expected content');
    }

    public function testTag_berhasil()
    {
        // Preparation: Create a product with the slug 'example-slug'
        $slug = 'slug-yang-ditemukan';
        Product::factory()->create(['slug' => $slug]);

        // Action: Perform an HTTP GET request to the endpoint '/'
        $response = $this->get('/');

        // Assert: Ensure the response status is 200
        $response->assertStatus(200);
    }

    public function testTag_tidakDitemukan()
    {
        // Suppose we want to test a slug that does not exist in the database
        $slug = 'slug-yang-tidak-ditemukan';

        // Perform an HTTP GET request to the appropriate endpoint
        $response = $this->get('/' . $slug);

        // Check if the response status is 404
        $response->assertStatus(404);
    }
}
