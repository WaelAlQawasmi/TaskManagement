<?php

namespace Tests\Unit;

use App\Models\Task;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
        Task::factory()->count(10)->create();

        // Make a GET request to the index endpoint
        $response = $this->get('/');

        // Assert that the response is successful
        $response->assertStatus(200);
    }
}
