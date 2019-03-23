<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Company::class, function (Faker $faker) {
    return [
        'name'=> $faker->company,
        'legal_id'=> $faker->unique->randomNumber(),
        'address'=> $faker->address
    ];
});
