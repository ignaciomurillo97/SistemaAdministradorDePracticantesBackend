<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable =[
        'semester', 'start', 'end',
    ];
}
