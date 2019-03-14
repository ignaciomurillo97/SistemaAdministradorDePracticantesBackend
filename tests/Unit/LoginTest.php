<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Person;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTests extends TestCase
{
    public function test_Login_ValidPasswordAndEmail_AccessTokenReturned() {
        $response = $this->loginRequest('password', 1);
        $content = json_decode($response->getContent());
        $this->assertTrue(isset($content->data));
    }

    public function test_Login_InvalidPasswordValidEmail_InvalidCredentialsReturned() {
        $response = $this->loginRequest('passwor', 1);
        $content = json_decode($response->getContent());
        $this->assertTrue(!isset($content->data));
        $this->assertTrue(isset($content->error));
    }

    public function test_Login_ValidPasswordInvalidEmail_InvalidCredentialsReturned() {
        $response = $this->loginRequest('password', 1, true);
        $content = json_decode($response->getContent());
        $this->assertTrue(!isset($content->data));
        $this->assertTrue(isset($content->error));
    }

    public function loginRequest($password, $scope, $invalidEmail = false) {
        $user = User::where('scope_id', $scope)->first();
        return $this->withHeaders([
            'Accept' => 'application/json'
        ])->json('POST', "/api/login", [
            'email' => $invalidEmail? 'invalid@email.com' : $user->email,
            'password' => $password
            ]);
    }

}
