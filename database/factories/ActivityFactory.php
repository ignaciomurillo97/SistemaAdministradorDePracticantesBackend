<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Activity::class, function (Faker $faker) {
    return [
    	'id'=> $faker->unique()->randomNumber(),
    	'start'=> $faker->time($format = 'H:i:s', $max = 'now'),
    	'finish'=> $faker->time($format = 'H:i:s', $max = 'now'),
    ];
});
