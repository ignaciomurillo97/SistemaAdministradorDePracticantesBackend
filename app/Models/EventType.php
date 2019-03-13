<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
	public $timestamps = false;
    protected $table = 'event_types';
    protected $fillable = ['name','description'];
}
