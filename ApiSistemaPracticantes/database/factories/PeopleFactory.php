<?php

use Faker\Generator as Faker;
use App\Person;

$factory->define(Person::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->randomNumber(),
        'name' => $faker->firstName,
        'lastName' => $faker->lastName,
        'secondLastName' => $faker->lastName,
        'gender' => $faker->randomElement([0, 1])
    ];
});
