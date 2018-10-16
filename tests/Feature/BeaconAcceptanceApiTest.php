<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BeaconAcceptanceApiTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        $this->Beacon = factory(App\Models\Beacon::class)->make([
            'id' => '1',
		'mac' => 'assumenda',
		'host' => 'impedit',

        ]);
        $this->BeaconEdited = factory(App\Models\Beacon::class)->make([
            'id' => '1',
		'mac' => 'assumenda',
		'host' => 'impedit',

        ]);
        $user = factory(App\Models\User::class)->make();
        $this->actor = $this->actingAs($user);
    }

    public function testIndex()
    {
        $response = $this->actor->call('GET', 'api/v1/beacons');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStore()
    {
        $response = $this->actor->call('POST', 'api/v1/beacons', $this->Beacon->toArray());
        $this->assertEquals(200, $response->getStatusCode());
        $this->seeJson(['id' => 1]);
    }

    public function testUpdate()
    {
        $this->actor->call('POST', 'api/v1/beacons', $this->Beacon->toArray());
        $response = $this->actor->call('PATCH', 'api/v1/beacons/1', $this->BeaconEdited->toArray());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('beacons', $this->BeaconEdited->toArray());
    }

    public function testDelete()
    {
        $this->actor->call('POST', 'api/v1/beacons', $this->Beacon->toArray());
        $response = $this->call('DELETE', 'api/v1/beacons/'.$this->Beacon->id);
        $this->assertEquals(200, $response->getStatusCode());
        $this->seeJson(['success' => 'beacon was deleted']);
    }

}
