<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\EventType;
use App\Models\Event;

class EventTest extends TestCase
{
	use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_GetAllEvents_RequestApi_ReturnsAllEvents()
    {
    	$eventType = factory(EventType::class)->create();
    	$event = factory(Event::class, 10)->create([
    		'type_id' => $eventType->id
    	]);
        $result = $this->json('GET', '/api/events');
        $decodedResult = json_decode($result->getContent());
        $resultSize = sizeof($decodedResult->data);
        $expectedSize = count(Event::all());
        $this->assertTrue($resultSize == $expectedSize);
    }

    public function test_createEvent_POSTRequest_AppearsInDatabase() {
    	// Add Event Type
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
        $this->assertDatabaseHas('events', ['name' => 'event']);
    }
}
