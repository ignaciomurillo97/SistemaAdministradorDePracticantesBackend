<?php

use Illuminate\Database\Seeder;

class PeopleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Person::class, 10)->create()->each(function ($person) {
            $person->user()->save(factory(App\User::class)->make());
        });
    }
}
