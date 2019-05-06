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

    public static function hasConfirmed($user){
    	$result = DB::table('people_per_event')->select('confirmed')->where('person_id','=',$user)->get();
    	return count($result) != 0;
    }
}
