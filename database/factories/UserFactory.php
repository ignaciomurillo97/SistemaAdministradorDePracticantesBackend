<?php

use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'person_id' => 0, // Place holder, se reemplaza en el seeder cuando se crea el usuario
        'scope_id' => $faker->randomElement([1, 5]), // solo crea administradores y profesores ya que el resto de tipos de usuario requiere clases extra por lo que son creados en el factory respectivo
        'remember_token' => Str::random(10),
    ];
});
