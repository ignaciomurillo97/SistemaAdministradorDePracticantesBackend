<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public $timestamps = false;
    protected $table = 'activity';
    protected $fillable = ['duration','event_id','company_id','activityName','duration','charlista','remarks'];
}
