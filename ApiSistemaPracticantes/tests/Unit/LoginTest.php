<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Person;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTests extends TestCase
{
    //administrator
    public function test_AdministratorLogin_ValidPasswordAndScope_AccessTokenReturned() {
        $response = $this->loginRequest('administrator', 'password', 1);
        $content = json_decode($response->getContent());
        $this->assertTrue(isset($content->data));
    }

    public function test_AdministratorLogin_ValidPasswordInvalidScopoe_AccessDeniedReturned() {
        $response = $this->loginRequest('administrator', 'password', 2);
        $content = json_decode($response->getContent());
        $this->assertTrue(!isset($content->data));
    }

    public function test_AdministratorLogin_invalidPasswordValidScopoe_AccessDeniedReturned() {
        $response = $this->loginRequest('administrator', 'password', 2);
        $content = json_decode($response->getContent());
        $this->assertTrue(!isset($content->data));
    }

    // Coordinator
    public function test_CoordinatorLogin_ValidPasswordAndScope_AccessTokenReturned() {
        $response = $this->loginRequest('coordinator', 'password', 2);
        $content = json_decode($response->getContent());
        $this->assertTrue(isset($content->data));
    }

    public function test_CoordinatorLogin_ValidPasswordInvalidScopoe_AccessDeniedReturned() {
        $response = $this->loginRequest('coordinator', 'password', 1);
        $content = json_decode($response->getContent());
        $this->assertTrue(!isset($content->data));
    }

    public function test_CoordinatorLogin_invalidPasswordValidScopoe_AccessDeniedReturned() {
        $response = $this->loginRequest('coordinator', 'password', 1);
        $content = json_decode($response->getContent());
        $this->assertTrue(!isset($content->data));
    }

    // Student
    public function test_StudentLogin_ValidPasswordAndScope_AccessTokenReturned() {
        $response = $this->loginRequest('student', 'password', 3);
        $content = json_decode($response->getContent());
        $this->assertTrue(isset($content->data));
    }

    public function test_StudentLogin_ValidPasswordInvalidScopoe_AccessDeniedReturned() {
        $response = $this->loginRequest('student', 'password', 1);
        $content = json_decode($response->getContent());
        $this->assertTrue(!isset($content->data));
    }

    public function test_StudentLogin_invalidPasswordValidScopoe_AccessDeniedReturned() {
        $response = $this->loginRequest('student', 'password', 1);
        $content = json_decode($response->getContent());
        $this->assertTrue(!isset($content->data));
    }

    // Company
    public function test_CompanyLogin_ValidPasswordAndScope_AccessTokenReturned() {
        $response = $this->loginRequest('company', 'password', 4);
        $content = json_decode($response->getContent());
        $this->assertTrue(isset($content->data));
    }

    public function test_CompanyLogin_ValidPasswordInvalidScopoe_AccessDeniedReturned() {
        $response = $this->loginRequest('company', 'password', 1);
        $content = json_decode($response->getContent());
        $this->assertTrue(!isset($content->data));
    }

    public function test_CompanyLogin_invalidPasswordValidScopoe_AccessDeniedReturned() {
        $response = $this->loginRequest('company', 'password', 1);
        $content = json_decode($response->getContent());
        $this->assertTrue(!isset($content->data));
    }


    public function loginRequest($route, $password, $scope) {
        $user = User::where('scope_id', $scope)->first();
        return $this->withHeaders([
            'Accept' => 'application/json'
        ])->json('POST', "/api/{$route}/login", [
            'email' => $user->email,
            'password' => $password
            ]);
    }

}