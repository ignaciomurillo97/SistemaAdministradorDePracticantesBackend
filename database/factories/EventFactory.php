<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Event::class, function (Faker $faker) {
    return [
        'id'=> $faker->unique()->randomNumber(),
        'eventDate'=> $faker->date($format = 'Y-m-d', $max = 'now'),
        'start'=> $faker->time($format = 'H:i:s', $max = 'now'),
        'finish'=> $faker->time($format = 'H:i:s', $max = 'now'),
        'image'=> 'default.jpg',
        'name'=> $faker->word
    ];
});
