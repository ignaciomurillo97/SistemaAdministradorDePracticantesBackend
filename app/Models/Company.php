<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    protected $fillable = ['name','legal_id','address','person_id'];

    public function person () {
        return $this->belongsTo('App\Models\Person');
    }
}
