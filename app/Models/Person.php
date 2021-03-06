<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    public $incrementing = false; // Don't use auto increment

    public function user() {
        return $this->hasOne('App\Models\User');
    }

    public function gender() {
        return $this->belongsTo('App\Models\Gender');
    }

    public function student () {
        return $this->hasOne('App\Models\Student');
    }

    public function company() {
        return $this->hasOne('App\Models\Company');
    }

    public function coordinator() {
        return $this->hasOne('App\Models\Coordinator');
    }

    protected $fillable = [
        'id', 'name', 'lastName', 'secondLastName', 'gender_id', 'birthday', 'telephone'
    ];
}
