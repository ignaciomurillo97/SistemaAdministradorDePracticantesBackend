<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Activity;
use App\Models\Event;
use App\Models\EventType;
use App\Models\Company;
use App\Models\User;
use Laravel\Passport\Passport;

class ActivityTest extends TestCase
{
	use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_GetAllActivities_RequestApi_ReturnsAllActivities()
    {
        Passport::actingAs(
            User::where('scope_id', '1')->first(),
            ['super-user']
        );

    	$company = factory(Company::class)->create();
    	$eventType = factory(EventType::class)->create();
    	$event = factory(Event::class)->create([
    		'type_id' => $eventType->id
    	]);
    	$activities = factory(Activity::class, 10)->create([
    		'event_id' => $event->id,
    		'company_id' => $company->legal_id
    	]);
        $result = $this->json('GET', '/api/activities');
        $decodedResult = json_decode($result->getContent());
        $resultSize = sizeof($decodedResult->data);
        $expectedSize = count(Activity::all());
        $this->assertTrue($resultSize == $expectedSize);
    }

    public function test_createActivity_POSTRequest_AppearsInDatabase() {
    	// Add Event Type
        Passport::actingAs(
            User::where('scope_id', '1')->first(),
            ['super-user']
        );

    	$this->json('POST', "/api/eventTypes", ['name' => 'eventType']);
    	$result = $this->json('GET', '/api/eventTypes');
        $type_id = json_decode($result->getContent())->data[0]->id;
        
        // Add Event
        $this->json('POST', "/api/events", [
        	'name' => 'event', 
        	'date'=>'2019-03-12', 
        	'start'=>'10:10:00',
        	'finish'=>'11:10:02',
        	'image'=>'http://lorempixel.com/640/480/',
        	'type'=>$type_id]);
        $result = $this->json('GET', '/api/events');
        $event_id = json_decode($result->getContent())->data[0]->id;
        
        // Add Company
    	$this->json('POST', "/api/companies", ['name' => 'ITCR for testing', 'legal_id'=>'3089201293', 'address'=>'Alajuela','person_id'=>User::where('scope_id', '4')->first()->person_id]);
        
        // Add Activity to Event
        $this->json('POST', "/api/activities", ['duration'=>'30:00','event'=>$event_id,'company'=>'3089201293','activityName'=>'Como hacer su CV','charlista'=>'Pedrito Navarro','remarks'=>'Necesito laptop, video beam y se realizaran entrevistas']);

        
        // Assertion
        $this->assertDatabaseHas('activities', ['activityName' => 'Como hacer su CV']);
    }
}
