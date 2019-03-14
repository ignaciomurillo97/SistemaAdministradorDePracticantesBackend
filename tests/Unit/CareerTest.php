<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Career;
use App\Models\User;
use Laravel\Passport\Passport;

class CareerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_GetAllCareers_RequestApi_ReturnsAllCareers()
    {
        $result = $this->json('GET', '/api/careers');
        $decodedResult = json_decode($result->getContent());
        $resultSize = sizeof($decodedResult->data);
        $expectedSize = count(Career::all());
        $this->assertTrue($resultSize == $expectedSize);
    }

    public function test_GetCareer_RequestExistentCareer_ReturnsRequestedCareer() {
        $randomCareer = Career::inRandomOrder()->first();
        $result = $this->json('GET', "/api/career/$randomCareer->id");
        $career = json_decode($result->getContent())->data;
        $this->assertTrue($this->careerCompare($career, $randomCareer));
    }

    public function test_GetCareer_RequestNonexistentCareer_ReturnsRequestedCareer() {
        $result = $this->json('GET', "/api/career/0");
        $resultDecoded = json_decode($result->getContent());
        $this->assertTrue(
            $resultDecoded->data == "Failed" &&
            $resultDecoded->error == "No se encontro la carrera"
        );
    }

    public function test_createCareer_POSTRequest_AppearsInDatabase() {
        Passport::actingAs(
            User::where('scope_id', '1')->first(),
            ['super-user']
        );

        $this->json('POST', "/api/career", ['career' => 'career created for testing']);
        $this->assertDatabaseHas('careers', ['career' => 'career created for testing']);
    }

    public function test_updateCareer_PUTRequestExistentCareer_AppearsInDatabase() {
        Passport::actingAs(
            User::where('scope_id', '1')->first(),
            ['super-user']
        );

        $randomCareer = Career::inRandomOrder()->first();
        $this->json('PUT', "/api/career/$randomCareer->id", ['career' => 'career updated for testing']);
        $this->assertDatabaseHas('careers', ['career' => 'career updated for testing']);
    }

    public function test_updateCareer_POSTRequestNonexistentCareer_AppearsInDatabase() {
        Passport::actingAs(
            User::where('scope_id', '1')->first(),
            ['super-user']
        );

        $result = $this->json('PUT', "/api/career/0", ['career' => 'career updated for testing']);
        $resultDecoded = json_decode($result->getContent());
        $this->assertTrue(
            $resultDecoded->data == "Failed" &&
            $resultDecoded->error == "La carrera no existe"
        );
    }

    public function test_deleteCareer_DeleteExistentCareer_DoesntAppearInDatabse() {
        Passport::actingAs(
            User::where('scope_id', '1')->first(),
            ['super-user']
        );
        $randomCareer = Career::inRandomOrder()->first();
        $this->json('DELETE', "/api/career/$randomCareer->id");
        $this->assertDatabaseMissing('careers', ['id' => $randomCareer->id]);
    }


    public function test_deleteCareer_DeleteNonexistentCareer_DoesntAppearInDatabse() {
        Passport::actingAs(
            User::where('scope_id', '1')->first(),
            ['super-user']
        );
        $result = $this->json('DELETE', "/api/career/0");
        $resultDecoded = json_decode($result->getContent());
        $this->assertTrue(
            $resultDecoded->data == "Failed" &&
            $resultDecoded->error == "La carrera no existe"
        );
    }

    public function careerCompare($career1, $career2) {
        return $career1->id == $career2->id && $career1->career == $career2->career;
    }
}
