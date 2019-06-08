<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipProcessEvaluation extends Model
{
    protected $cast = [
        'evaluation' => 'array'
    ];
    protected $fillable = ['student_id', 'evaluation'];
}
