<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
class AuthenticationTest extends TestCase
{
    use WithoutMiddleware;

    // public function testSuccessfulRegistration()
    // {
    //     $userData = [
    //         'name' => 'juan dela cruz',
    //         'email' => 'backend@multisyscorp.com',
    //         "password" => "test123",
    //         "password_confirmation" => "test123"
    //     ];

    //     $this->json('POST', 'api/guest/register', $userData, ['Accept' => 'application/json'])
    //         ->assertStatus(201)
    //         ->assertJsonStructure([
    //             "message"
    //         ]);
    // }

    // public function testUnsuccessfulRegistration()
    // {
    //     $userData = [
    //         'name' => 'juan dela cruz',
    //         'email' => 'backend@multisyscorp.com',
    //         "password" => "test123",
    //         "password_confirmation" => "test123"
    //     ];

    //     $this->json('POST', 'api/guest/register', $userData, ['Accept' => 'application/json'])
    //         ->assertStatus(400)
    //         ->assertJson([
    //             "email" => [
    //                 "The email has already been taken.",
    //             ],
    //         ]);
    // }

     public function testSuccessfulLogin()
    {
        $loginData = ['email' => 'backend@multisyscorp.com', 'password' => 'test123'];

        $this->json('POST', 'api/guest/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                "data" => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ],
                "access_token",
            ]);

            $this->assertAuthenticated();
    }

    // public function testInvalidLogin()
    // {
    //     $userData = [
    //         'email' => 'backend123123@multisyscorp.com',
    //         "password" => "test121231233"
    //     ];

    //     $this->json('POST', 'api/guest/login', $userData, ['Accept' => 'application/json'])
    //         ->assertStatus(401)
    //         ->assertJson([
    //             "message" => "Invalid credentials",
    //         ]);
    // }
}
