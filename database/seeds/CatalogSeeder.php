<?php

use Illuminate\Database\Seeder;
use App\Models\Gender;
use App\Models\Scope;

class CatalogSeeder extends Seeder
{
    public function createGenders() {
        $male = new Gender;
        $male->gender = 'masculino';
        $male->save();


        $female = new Gender;
        $female->gender = 'female';
        $female->save();

        $other = new Gender;
        $other->gender = 'other';
        $other->save();
    }

    public function createScopes() {
        $superuser = new Scope;
        $superuser->scope = 'super-user';
        $superuser->save();

        $coordinator = new Scope;
        $coordinator->scope = 'coordinator';
        $coordinator->save();
        
        $student = new Scope;
        $student->scope = "student";
        $student->save();

        $company = new Scope;
        $company->scope = "company";
        $company->save();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createGenders();
        $this->createScopes();
    }

}