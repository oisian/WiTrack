<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BeaconRecordAcceptanceApiTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        $this->BeaconRecord = factory(App\Models\BeaconRecord::class)->make([
            ''id' => '1',

        ]);
        $this->BeaconRecordEdited = factory(App\Models\BeaconRecord::class)->make([
            ''id' => '1',

        ]);
        $user = factory(App\Models\User::class)->make();
        $this->actor = $this->actingAs($user);
    }

    public function testIndex()
    {
        $response = $this->actor->call('GET', 'api/v1/beacon_records');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStore()
    {
        $response = $this->actor->call('POST', 'api/v1/beacon_records', $this->BeaconRecord->toArray());
        $this->assertEquals(200, $response->getStatusCode());
        $this->seeJson(['id' => 1]);
    }

    public function testUpdate()
    {
        $this->actor->call('POST', 'api/v1/beacon_records', $this->BeaconRecord->toArray());
        $response = $this->actor->call('PATCH', 'api/v1/beacon_records/1', $this->BeaconRecordEdited->toArray());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('beacon_records', $this->BeaconRecordEdited->toArray());
    }

    public function testDelete()
    {
        $this->actor->call('POST', 'api/v1/beacon_records', $this->BeaconRecord->toArray());
        $response = $this->call('DELETE', 'api/v1/beacon_records/'.$this->BeaconRecord->id);
        $this->assertEquals(200, $response->getStatusCode());
        $this->seeJson(['success' => 'beacon_record was deleted']);
    }

}
