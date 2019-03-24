<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $timestamps = false;
    protected $table = 'company';
    protected $fillable = ['name','legal_id','address','person_id'];
}
