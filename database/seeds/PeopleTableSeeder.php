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
        factory(App\Models\Person::class, 40)->create()->each(function ($person) {
            $person->user()->save(factory(App\Models\User::class)->make());
        });
        $this->createStudents();
    }

    private function createStudents() {
        factory(App\Models\Person::class, 10)->create()->each(function ($person) {
            $person->student()->save(factory(App\Models\Student::class)->make());
            $person->user()->scope_id = 0;
        });
    }
}
