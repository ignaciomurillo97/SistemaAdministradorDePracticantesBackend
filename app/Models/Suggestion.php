<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected $table = 'suggestions';
    protected $fillable = ['duration','event_id','person_id','name','duration','charlista','remarks'];

}
