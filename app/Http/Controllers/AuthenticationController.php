<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
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

    public function userHasAccess(string $email) {
        $userPerson = User::where('email', $email)->first();
        if (!isset($userPerson)) return false;
        return $userPerson->scope->scope == $scope;
    }

    public function getUser (string $email) {
        $userPerson = User::where('email', $email)->first();
        if (!isset($userPerson)) return false;
        return $userPerson;
    }

    public function login(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');
        $user = $this->getUser($email);
        $scope = $user->scope->scope;

        $tokenRequest = $this->requestToken($email, $password, $scope, $request);
        $data = [
            "token" => json_decode(Route::dispatch($tokenRequest)->getContent()),
            "person_id" => $user->person_id,
            "person_type" => $user->scope->scope
        ];
        if (isset($data->error)) {
            return response(makeResponseObject(null, "Invalid Credentials"), 403);
        } else {
            return response(makeResponseObject($data, null), 200);
        }

    }
}
