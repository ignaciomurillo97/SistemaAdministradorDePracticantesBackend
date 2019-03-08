<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;
use Config;
use App\Helpers\ResponseWrapper;

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

    public function userHasAccess(string $email, string $scope) {
        $userPerson = User::where('email', $email)->first();
        if (!isset($userPerson)) return false;
        return $userPerson->scope->scope == $scope;
    }

    public function login(Request $request, string $scope) {
        $email = $request->input('email');
        $password = $request->input('password');
        if (!$this->userHasAccess($email, $scope)) {
            return response(makeResponseObject("", "Access Denied"), 403);
        }
            $tokenRequest = $this->requestToken($email, $password, $scope, $request);
            $data = json_decode(Route::dispatch($tokenRequest)->getContent());
            return response(makeResponseObject($data, ""), 200);
    }


}