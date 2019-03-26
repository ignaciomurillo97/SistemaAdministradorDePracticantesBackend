<?php

use Faker\Generator as Faker;

function getInstanceOf($class) {
    $instance = $class::inRandomOrder()->first() ?? factory($class)->create();
    return $instance;
}

$factory->define(App\Models\Student::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->randomNumber(), // Carne
        'person_id' => 0,
        'career_id' => getInstanceOf(App\Models\Career::class)->id,
        'site_id' => getInstanceOf(App\Models\Site::class)->id,
        'status' => $faker->randomElement([1, 2, 3]),
        'semester_id' => $faker->randomElement([1, 2, 3]),
        'image' => '/image/tmp.jpg'
    ];
});

