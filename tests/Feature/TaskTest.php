<?php

namespace Tests\Feature;

use App\Http\Controllers\TaskController;
use App\Models\Task;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Class TaskTest
 *
 * This class contains unit tests for the Task API endpoints.
 */
class TaskTest extends TestCase
{
    /**
     * The authenticated user for testing.
     *
     * @var \App\Models\User
     */
    protected $user;
    /**
     * The task being used for testing.
     *
     * @var \App\Models\Task
     */
    protected $task;

    /**
     * Set up the test environment.
     *
     * This method runs before each test method.
     */
    public function setUp(): void
    {
        parent::setUp();
        // Retrieve an authenticated user with admin privileges
        $this->user = User::where('email', 'admin@test.com')->first();
        Passport::actingAs($this->user);

        // Create a task for testing purposes
        $this->task = Task::create([
            'title' => "task title",
            'description' => "description",
            'assigned_user_id' =>  $this->user->id,
            'creator_user_id' =>  $this->user->id,
            'status' => TaskController::pendingStatus,
        ]);
    }
    
    /**
     * Clean up after each test method.
     */
    public function tearDown(): void
    {
        parent::tearDown();
        $this->task->delete();
    }
    /**
     * Test creating a task and then deleting it.
     *
     * @return void
     */
    public function test_create_task_and_delete_it()
    {
        $response = $this->postJson('/api/task', [
            'title' => 'Test Task',
            'description' => 'This is a test task',
            'creator_user_id' =>  $this->user->id,
        ]);
        $this->task = Task::find($response['task_id']);

        $response->assertStatus(201);
        $deleteResponse = $this->delete("/api/task/{$response['task_id']}");
        $deleteResponse->assertStatus(204);
    }
    /**
     * Test updating a task.
     *
     * @return void
     */
    public function test_update_task()
    {

        $updateResponse = $this->put("/api/task/{$this->task->id}", [
            'title' => ' new Test Task',
        ]);
        $updateResponse->assertStatus(200);
    }


    public function test_read_task()
    {
        $Response = $this->get("/api/task/{$this->task->id}");
        $Response->assertStatus(200);
        $this->assertEquals('task title', $Response['title']);
    }


    public function test_filter_tasks()
    {
        $Response = $this->get("/api/tasks-filter/pending");
        $Response->assertStatus(200);
        $Response = $this->get("/api/tasks-filter/completed");
        $Response->assertStatus(200);
    }


    public function test_complete_task()
    {
        $Response = $this->post("/api/mark-tasks-completed/{$this->task->id}");
        $Response->assertStatus(200);
    }


    public function test_assign_task()
    {
        $Response = $this->post("/api/assign-task/{$this->task->id}", ['assignedUserId' => $this->user->id]);
        $Response->assertStatus(200);
    }

    public function test_delete_task()
    {
        $deleteResponse = $this->delete("/api/task/{$this->task->id}");
        $deleteResponse->assertStatus(204);
    }
}
