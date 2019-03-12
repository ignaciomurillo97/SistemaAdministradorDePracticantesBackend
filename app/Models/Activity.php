<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public $timestamps = false;
    protected $table = 'activity';
    protected $fillable = ['start','finish','event_id','company_id'];
}
