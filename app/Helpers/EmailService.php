<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\PasswordResetEmail;


class EmailService {
    public static function resetPassword($email, $name, $token) {
        $body = new PasswordResetEmail($name, $token);
        Mail::to($email)->send($body);
    }
}
