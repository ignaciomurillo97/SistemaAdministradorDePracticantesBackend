<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Company;

class CompanyTest extends TestCase
{
	use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_GetAllCompanies_RequestApi_ReturnsAllCompanies()
    {
        $companies = factory(Company::class, 10)->create();
        $result = $this->json('GET', '/api/companies');
        $decodedResult = json_decode($result->getContent());
        $resultSize = sizeof($decodedResult->data);
        $expectedSize = count(Company::all());
        $this->assertTrue($resultSize == $expectedSize);
    }

    public function test_createCompany_POSTRequest_AppearsInDatabase()
    {
        $this->json('POST', "/api/companies", ['legal_id'=>'3789102011', 'name'=>'ITCR for testing', 'address'=>'San Jose']);
        $this->assertDatabaseHas('company', ['legal_id'=>'3789102011']);
    }
}
