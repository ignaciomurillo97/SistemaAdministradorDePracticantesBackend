<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['data'=> 'success','error' => NULL]);
    }

    public function send()
    {
        $email = 'luispama96@hotmail.com';
        $name = 'Luis Pablo';
        Mail::to($email)->send(new SendEmail($name));
        return response()->json(['data'=> 'email sent','error' => NULL]);
    }

}
