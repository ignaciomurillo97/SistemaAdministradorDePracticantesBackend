<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $incrementing = false;
    protected $fillable = [
        'id', 'person_id', 'career_id', 'site_id', 'status'
    ];
}
