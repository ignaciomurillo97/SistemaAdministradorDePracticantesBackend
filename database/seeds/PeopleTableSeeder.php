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
        $this->createCompanies();
        $this->createEventTypesAndEvents();
    }

    private function createStudents() {
        factory(App\Models\Person::class, 10)->create()->each(function ($person) {
            $person->user()->save(factory(App\Models\User::class)->make(['scope_id'=>'3']));
            $person->student()->save(factory(App\Models\Student::class)->make());
        });
    }

    private function createCompanies() {
        factory(App\Models\Person::class, 10)->create()->each(function($person){
            $person->user()->save(factory(App\Models\User::class)->make(['scope_id'=>'4']));
            factory(App\Models\Company::class)->create(['person_id'=>$person]);
        });
    }

    private function createEventTypesAndEvents() {
        factory(App\Models\EventType::class, 5)->create()->each(function($eventType){
            factory(App\Models\Event::class, 10)->create(['type_id'=>$eventType]);
        });
    }
}
