<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordinator extends Model
{
    public $fillable = ['site_id', 'career_id', 'person_id'];

    public function person () {
        return $this->belongsTo('App\Models\Person');
    }

    public function semester () {
        return $this->belongsTo('App\Models\Semester');
    }

    public function career () {
        return $this->belongsTo('App\Models\Career');
    }

}
