<?php

namespace Tests\Feature;

use App\Models\User;

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
        $response = $this->post('/api/login', [
            'email' => 'admin@test.com',
            'password' => '123456',
        ]);
        $response->assertStatus(200);
        $this->assertAuthenticated(); 
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
