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
        $this->createCoordinator();
        $this->createEventTypesAndEvents();
        $this->createRubric();
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

    private function createCoordinator() {
        factory(App\Models\Person::class, 10)->create()->each(function($person){
            $person->user()->save(factory(App\Models\User::class)->make(['scope_id'=>'2']));
            factory(App\Models\Coordinator::class)->create(['person_id'=>$person]);
        });
    }

    private function createEventTypesAndEvents() {
        factory(App\Models\EventType::class, 5)->create()->each(function($eventType){
            factory(App\Models\Event::class, 10)->create(['type_id'=>$eventType]);
        });
    }

    private function createRubric() {
        DB::table('rubric')->insert(['json_rubric'=>'{"Rubrica":{"Descipción":["Describe claramente en qué consiste el proyecto.Tiene un propósito claro, sabe a quién va dirigido.La justificación hace válida la ejecución del proyecto.El proyecto tiene un impacto alto.","Describe claramente en qué consiste el proyecto.Tiene un propósito claro, sabe a quién va dirigido.La justificación hace válida la ejecución del proyecto.El proyecto tiene un impacto alto pero tiene leves oportunidades de mejora.","El proyecto está definido pero requiere mejoras.El impacto es medio.","El impacto del proyecto es bajo.No está bien definido el propósito.","La descripción no es clara. El impacto del proyecto es bajo o no está definido el propósito."],"Antecedentes":["Explicación clara y concisa del contexto del proyecto.","Explica el contexto pero requiere leves mejoras.","Explica el contexto pero le falta desarrollarlo.","No tiene claro el contexto del proyecto.","No explica el contexto."],"Objetivos":["Los objetivos están claros y corresponde al fin principal del proyecto.","Cumple con lo anterior pero le faltan leves mejoras.","Los objetivos está bien pero no van acorde al proyecto.","Los objetivos está incorrecto.","No están redactado como objetivos."],"Tecnologías":["La tecnología a utilizar es de punta, accesible o libre. Presenta tecnología tanto para web, apps, bases de datos, otros que requiera la empresa.","Cumple con lo anterior pero requiere mejoras.","Cumple con lo anterior pero le falta definir tecnología para parte del proyecto.","La tecnología no está claramente definida en su totalidad.","La tecnología a utilizar no fue definida."],"Alcance":["El alcance es SMART. Explica claramente lo que se va a obtener con el proyecto y lo que no. Define el trabajo a futuro.","Cumple con lo anterior pero requiere mejoras.","Le falta lo que no se va a hacer o el trabajo futuro.","No está claro el alcance. Se ve limitado y no cumple con SMART.","No está claro el alcance."],"Stakeholders":["En un cuadro, resumen los stakeholders, contacto, empresa y responsabilidades.","Cumple con lo anterior pero requiere mejoras.","No incluye a todos los stakeholders u omite parte de la infomación requerida. ","Solo menciona a los stakeholders. ","No incluye el personal involucrado del proyecto."],"Duración":["Cumple con la duración asignada por el Tecnológico de Costa Rica.","","Omite fecha de inicio o final.","","No incluye duración del proyecto."],"Cronograma":["Presenta un cronograma tanto el listado de actividades con fecha y responable.","Cumple con lo anterior pero requiere mejoras.","Cumple con lo anterior pero omite detalles.","Al cronograma le faltan actividades.","El cronograma no está completo. No se identifican todas las actividades a realizar."]}}']);
    }
}
