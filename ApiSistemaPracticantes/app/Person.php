<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    public $incrementing = false; // Don't use auto increment

    public function user() {
        return $this->hasOne('App/User');
    }
}
