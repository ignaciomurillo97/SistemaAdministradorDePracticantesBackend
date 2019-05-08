<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Coordinator::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->randomNumber(), // Carne
        'person_id' => 0,
        'career_id' => getInstanceFromDB(App\Models\Career::class)->id,
        'site_id' => getInstanceFromDB(App\Models\Site::class)->id,
    ];
});
