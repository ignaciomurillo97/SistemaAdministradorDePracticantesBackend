<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Config;

class AuthenticationController extends Controller
{
    private function requestToken(string $email, string $password, string $scope, Request $request) {
        $request->request->add([
                'grant_type' => 'password',
                'client_id' => config('passportCredentials.id'),
                'client_secret' => config('passportCredentials.secret'),
                'username' => $email,
                'password' => $password,
                'scope' => $scope,
            ]
        );

        return Request::create('/oauth/token','post');
    }

    public function login(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');

        $tokenRequest = $this->requestToken($email, $password, 'super-user', $request);
        return Route::dispatch($tokenRequest);
    }


}