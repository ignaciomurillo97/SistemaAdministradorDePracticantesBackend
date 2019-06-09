<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipProfessorEvaluation extends Model
{
    protected $cast = [
        'evaluation' => 'array'
    ];
    protected $fillable = ['student_id', 'professor_id', 'evaluation'];
}
