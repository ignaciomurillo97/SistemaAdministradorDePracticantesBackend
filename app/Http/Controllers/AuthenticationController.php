<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Config;
use Hash;
use Carbon\Carbon;
use App\Helpers\EmailService;

use App\Models\User;
use App\Models\PasswordReset;
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

    public function getUser (string $email) {
        $userPerson = User::where('email', $email)->first();
        return $userPerson;
    }

    public function login(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');
        $user = $this->getUser($email);
        if (!isset($user)) {
            return response(makeResponseObject(null,"Invalid Credentials"), 403);
        }
        $scope = $user->scope->scope;

        $tokenRequest = $this->requestToken($email, $password, $scope, $request);
        $resultDecoded = json_decode(Route::dispatch($tokenRequest)->getContent());
        if (isset($resultDecoded->error)) {
            return response(makeResponseObject(null, "Invalid Credentials"), 403);
        } else {
            $data = [
                "token" => $resultDecoded,
                "person_id" => $user->person_id,
                "person_type" => $user->scope->scope
            ];
            return response(makeResponseObject($data, null), 200);
        }
    }

    public function requestPasswordReset(Request $request) {
        $email = $request->input('email');
        $token = $token = bin2hex(random_bytes(16));

        if (!User::where('email', $email)->exists()) {
            return makeResponseObject(null, 'Email does not exist');
        }

        try {
            $reset = PasswordReset::create([
                'email' => $email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            $reset->save();
        } catch (\Exception $e) {
            return makeResponseObject(null, 'Failed to reset password');
        }

        EmailService::resetPassword('ignaciomurillo97@gmail.com', 'Nacho', $token);

        return makeResponseObject('success', null);
    }
    
    public function resetPassword(string $token, Request $request) {
        $email = $request->input('email');
        $new_password = $request->input('password');
        $expiration_time = config('auth.passwords.users.expire');
        $resetRequest = PasswordReset::where([['email', $email], ['token', $token]])->orderBy('created_at')->first();

        if (!$resetRequest) {
            return makeResponseObject(null, 'Invalid token');
        }

        if ($this->isTokenExpired(Carbon::parse($resetRequest->created_at), $expiration_time)) {
            return makeResponseObject(null, 'Password reset token has expired');
        }

        $user = User::where('email', $email)->first();
        $user->password = bcrypt($new_password);
        $user->save();

        PasswordReset::where('email', $email)->delete();

        return makeResponseObject('success', null);
    }

    public function isTokenExpired($startDate, $expirationInDays){
        $dateDiff = $startDate->diffInDays(Carbon::now());
        return $dateDiff > $expirationInDays;
    }
}
