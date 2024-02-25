<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_and_create_task_and_delete_it()
    {
        $user = User::where('email','admin@test.com')->first();
        Passport::actingAs($user);

        $response = $this->postJson('/api/task', [
            'title' => 'Test Task',
            'description' => 'This is a test task',
            'creator_user_id' =>  $user->id,
        ]);

        // delete  the created task
        $response->assertStatus(201);
        $deleteResponse = $this->delete("/api/task/{$response['task_id']}");
        $deleteResponse->assertStatus(204);
       
    }

}
