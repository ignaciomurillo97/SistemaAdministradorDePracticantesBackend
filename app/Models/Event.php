<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	public $timestamps = false;
    protected $table = 'events';
    protected $fillable = ['name','eventDate','start','finish','image','type_id'];

    public static function confirmAssistance($user,$event){
    	
    }
}
