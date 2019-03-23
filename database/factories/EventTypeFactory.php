<?php

use Faker\Generator as Faker;

$factory->define(App\Models\EventType::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->randomNumber(),
        'name' => $faker->word,
        'description' => $faker->text($maxNbChars = 100)
    ];
});
