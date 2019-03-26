<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Activity::class, function (Faker $faker) {
    return [
    	'id'=> $faker->unique()->randomNumber(),
    	'duration'=> $faker->time($format = 'H:i:s', $max = 'now'),
    	'activityName'=> $faker->sentence($nbWords = 4, $variableNbWords = true),
    	'charlista'=>$faker->name,
    	'remarks'=>$faker->optional()->text($maxNbChars = 200)
    ];
});

// 'duration','event_id','company_id','activityName','charlista','remarks']