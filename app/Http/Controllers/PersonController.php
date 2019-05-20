<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PersonResource;
use App\Models\Person;

class PersonController extends Controller
{
    public function index(int $id){
        $person = Person::find($id);
        if ($person == null) {
            return makeResponseObject(null, "No se encontro la paersona");
        }
        return makeResponseObject(new PersonResource($person), null);
    }
}
