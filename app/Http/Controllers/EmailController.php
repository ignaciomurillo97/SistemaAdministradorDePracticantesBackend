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
        $body = new SendEmail($name);
        $response = response()->json(['data'=> 'email sent','error' => NULL]);
        try{
            Mail::to($email)->send($body);
        }catch(\Exception $e){
            $response = response()->json(['data'=> 'failed','error' => 'Email could not be sent']);
        }
        return $response;
    }

}
