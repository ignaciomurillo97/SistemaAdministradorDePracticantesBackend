<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Models\User;

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

    public function send($email)
    {
        $name = '';
        $body = new SendEmail($name);
        $response = response()->json(['data'=> 'email sent','error' => NULL]);
        try{
            Mail::to($email)->send($body);
        }catch(\Exception $e){
            $response = response()->json(['data'=> 'failed','error' => 'Email could not be sent']);
        }
        return $response;
    }

    public function notifyEvent(){
        $users = User::all();
        $response = response()->json(['data'=> 'emails sent','error' => NULL]);
        foreach($users as $user){
            $responses = self::send($user->email);
            if($responses->getdata()->error != NULL){
                return response()->json(['data'=> 'failed','error' => 'Email could not be sent']);
            }
        }
        return $response;
    }

}
