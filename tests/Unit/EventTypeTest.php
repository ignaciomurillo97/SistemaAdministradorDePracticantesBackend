<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\EventType;

class EventTypeTest extends TestCase
{
	use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_GetAllEventTypes_RequestApi_ReturnsAllEventTypes()
    {
    	$eventTypes = factory(EventType::class, 10)->create();
        $result = $this->json('GET', '/api/eventTypes');
        $decodedResult = json_decode($result->getContent());
        $resultSize = sizeof($decodedResult->data);
        $expectedSize = count(EventType::all());
        $this->assertTrue($resultSize == $expectedSize);
    }

    public function test_createEventType_POSTRequest_AppearsInDatabase() {
        $this->json('POST', "/api/eventTypes", ['name' => 'eventType']);
        $this->assertDatabaseHas('event_types', ['name' => 'eventType']);
    }
}
