<?php

use Illuminate\Database\Seeder;
use App\Models\Gender;
use App\Models\Scope;
use App\Models\Career;
use App\Models\Site;
use App\Models\Semester;

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

        $professor = new Scope;
        $professor->scope = "professor";
        $professor->save();
    }

    public function createCareersAndSites() {
        $career_computacion = $this->createCareer('Ingeniería en Computación');
        $career_arquitectura = $this->createCareer('Arquitectura y Urbanismo');
        $career_administracion = $this->createCareer('Administración de Empresas');

        $site_san_jose = $this->createSite('San Jose');
        $site_cartago = $this->createSite('Cartago');
        $site_alajuela = $this->createSite('Alajuela');

        $career_computacion->sites()->attach($site_san_jose->id);
        $career_computacion->sites()->attach($site_cartago->id);
        $career_computacion->sites()->attach($site_alajuela->id);

        $career_arquitectura->sites()->attach($site_san_jose->id);
        $career_arquitectura->sites()->attach($site_cartago->id);

        $career_administracion->sites()->attach($site_san_jose->id);
    }

    public function createSite($name) {
        $site = new Site(["site" => $name]);
        $site->save();
        return $site;
    }

    public function createCareer($name) {
        $career = new Career(["career" => $name]);
        $career->save();
        return $career;
    }

    public function createSemesters() {
        $semester = new Semester(["semester" => 1, "start"=>date_create("2019-2-6"), "end"=>date_create("2019-6-15")]);
        $semester->save();
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
        $this->createCareersAndSites();
        $this->createSemesters();
    }

}
