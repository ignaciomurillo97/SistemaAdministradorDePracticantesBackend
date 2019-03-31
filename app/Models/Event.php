<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Event extends Model
{
	public $timestamps = false;
    protected $table = 'events';
    protected $fillable = ['name','eventDate','start','finish','image','type_id'];

    public static function confirmAssistance($user,$event){
    	DB::table('people_per_event')->insert(
    		['person_id' => $user, 'event_id' => $event, 'confirmed' => true]);
    }
}
