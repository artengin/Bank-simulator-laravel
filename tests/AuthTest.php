<?php

namespace Tests;

class AuthTest extends TestCase
{
    public function testLogin()
    {
        $response = $this->postJson('/login', [
            'email' => 'admin@banksimulator.com',
            'password' => 'RImASnu',
        ]);

        $response->assertOk();

        $response->assertJsonStructure(['token']);
    }

    public function testLoginWrongPassword()
    {
        $response = $this->postJson('/login', [
            'email' => 'admin@banksimulator.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertUnauthorized();
    }

    public function testLoginWrongEmail()
    {
        $response = $this->postJson('/login', [
            'email' => 'notexist@domain.com',
            'password' => 'RImASnu',
        ]);

        $response->assertUnauthorized();
    }

    public function testLoginMissingEmail()
    {
        $response = $this->postJson('/login', [
            'password' => 'RImASnu',
        ]);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors('email');
    }

    public function testLoginMissingPassword()
    {
        $response = $this->postJson('/login', [
            'email' => 'admin@banksimulator.com',
        ]);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors('password');
    }
}
