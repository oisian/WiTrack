<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BeaconRecordAcceptanceTest extends TestCase
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
        $response = $this->actor->call('GET', 'beacon_records');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('beacon_records');
    }

    public function testCreate()
    {
        $response = $this->actor->call('GET', 'beacon_records/create');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStore()
    {
        $response = $this->actor->call('POST', 'beacon_records', $this->BeaconRecord->toArray());

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertRedirectedTo('beacon_records/'.$this->BeaconRecord->id.'/edit');
    }

    public function testEdit()
    {
        $this->actor->call('POST', 'beacon_records', $this->BeaconRecord->toArray());

        $response = $this->actor->call('GET', '/beacon_records/'.$this->BeaconRecord->id.'/edit');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('beacon_record');
    }

    public function testUpdate()
    {
        $this->actor->call('POST', 'beacon_records', $this->BeaconRecord->toArray());
        $response = $this->actor->call('PATCH', 'beacon_records/1', $this->BeaconRecordEdited->toArray());

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseHas('beacon_records', $this->BeaconRecordEdited->toArray());
        $this->assertRedirectedTo('/');
    }

    public function testDelete()
    {
        $this->actor->call('POST', 'beacon_records', $this->BeaconRecord->toArray());

        $response = $this->call('DELETE', 'beacon_records/'.$this->BeaconRecord->id);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertRedirectedTo('beacon_records');
    }

}
