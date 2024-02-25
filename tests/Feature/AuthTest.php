<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * test register  user.
     */
    public function test_register(){
        $response = $this->post('/api/signup', [
            'email' =>'x@mail.com',
            'password' => 'password',
            'name'=>'John Doe'
        ]);
        User::where('email','x@mail.com')->first()->delete();
        $response->assertStatus(201);
    }
    /**
     * test login  user with valid credentials.
     */
    public function test_login_with_correct_credentials()
    {
        $user = User::create([
            'name'=>'test',
            'role_id'=>2,
            'email'=>"qw@yui.com",
            'password' => bcrypt('password'), 
        ]);

        $response = $this->post('/api/login', [
            'email' => 'qw@yui.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticated();
        $user->delete();
    } 
    /**
     *  test login with  invalid password.
     */
    public function test_login_with_incorrect_credentials()
    {
       
        $response = $this->post('/api/login', [
            'email' => "email@mail.com",
            'password' => 'passwo25rd',
        ]);

        $response->assertStatus(401);
    } 
    /**
     *  test login  invalid email field.
     */
    public function test_login_with_validation_errors()
    {
        $response = $this->post('/api/login', [
            'email' => "emailmail.com",
            'password' => 'password',
        ]);
        $this->assertFalse($response['success']); 
        $this->assertEquals("Validation errors", $response['message']); 
        $this->assertArrayHasKey('email', $response['data']); 
        $this->assertContains("Please enter a valid email address.", $response['data']['email']); 
    }
}
