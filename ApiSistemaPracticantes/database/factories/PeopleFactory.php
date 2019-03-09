<?php

use Faker\Generator as Faker;
use App\Models\Person;

$factory->define(Person::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->randomNumber(),
        'name' => $faker->firstName,
        'lastName' => $faker->lastName,
        'secondLastName' => $faker->lastName,
        'gender_id' => $faker->randomElement([0, 1, 2])
    ];
});
