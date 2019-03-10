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
}