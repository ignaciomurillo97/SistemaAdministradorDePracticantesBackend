<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $incrementing = false;

    public function person () {
        return $this->belongsTo('App\Models\Person');
    }

    public function semester () {
        return $this->belongsTo('App\Models\Semester');
    }

    protected $fillable = [
        'id', 'person_id', 'career_id', 'site_id', 'status', 'semester_id', 'image','professorAssigned'
    ];
}
