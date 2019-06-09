<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rubric extends Model
{
    protected $table = 'rubric';
    protected $fillable = ['json_rubric'];
}
