<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Student::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->randomNumber(), // Carne
        'person_id' => 0,
        'career_id' => getInstanceFromDB(App\Models\Career::class)->id,
        'site_id' => getInstanceFromDB(App\Models\Site::class)->id,
        'status' => $faker->randomElement([1,2,3]),
        'semester_id' => $faker->randomElement([1, 2]),
        'image' => '/image/tmp.jpg'
    ];
});

